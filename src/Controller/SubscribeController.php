<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Controller;

use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\ModuleModel;
use Contao\PageModel;
use Contao\StringUtil;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Neo\BrevoNewsletterBundle\Brevo\BrevoClient;
use Neo\BrevoNewsletterBundle\Subscription\SubscribeRateLimiter;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Front-end endpoint for the newsletter sign-up: POST /api/brevo/subscribe.
 *
 * The API key is the one on "Access keys and licences" of the Basic bundle
 * (ApiKeyResolver, with the BREVO_API_KEY environment variable as fallback); the
 * opt-in template, confirmation page and authorised list(s) come from the
 * front-end module named in the request (so one key drives many sign-up
 * modules). In "fixed" mode the contact is added to all configured
 * lists; in "choice" mode only to the visitor's selection intersected with the
 * configured lists (never trusted from the client). Rate-limited per client, with
 * a honeypot + explicit consent flag. The e-mail address is not persisted/logged.
 *
 * A sign-up that does not reach Brevo (module incomplete, Brevo refuses it, no
 * connection) is an error in Contao's system log (System › System log), so the
 * operator sees it; the application log keeps Brevo's full answer.
 */
final class SubscribeController extends AbstractController
{
    public function __construct(
        private readonly ContaoFramework $framework,
        private readonly BrevoClient $brevo,
        private readonly ApiKeyResolver $apiKeys,
        private readonly SubscribeRateLimiter $limiter,
        private readonly ContentUrlGenerator $urls,
        private readonly LoggerInterface|null $logger = null,
        private readonly LoggerInterface|null $contaoErrorLog = null,
    ) {
    }

    public function subscribe(Request $request): Response
    {
        $this->framework->initialize();

        $wantsJson = $request->isXmlHttpRequest()
            || str_contains((string) $request->headers->get('Accept'), 'application/json');

        $payload = $this->payload($request);
        $redirect = null;
        $module = null;
        // No-JS fallback target: bounce back to the form page (referrer), NOT the
        // Brevo confirmation page — that one is only reached after the DOI click.
        $back = $this->backUrl($request);

        try {
            if (!$this->limiter->accept('nl-'.$request->getClientIp())) {
                return $this->result($wantsJson, 'rate_limited', 429, $back);
            }

            // Honeypot: a real user never fills this hidden field.
            if ('' !== trim((string) ($payload['website'] ?? ''))) {
                return $this->result($wantsJson, 'invalid', 400, $back);
            }

            $email = filter_var(trim((string) ($payload['email'] ?? '')), FILTER_VALIDATE_EMAIL);
            $consent = \in_array($payload['consent'] ?? null, [true, '1', 'on', 1], true);
            $module = $this->framework->getAdapter(ModuleModel::class)->findByPk((int) ($payload['mod'] ?? 0));

            if (false === $email || !$consent || null === $module || 'brevo_newsletter' !== $module->type) {
                return $this->result($wantsJson, 'invalid', 400, $back);
            }

            $redirect = $this->redirectUrl((int) $module->brevo_redirect);
            $configured = array_values(array_filter(array_map('intval', StringUtil::deserialize($module->brevo_lists, true))));
            $listIds = 'choice' === $module->brevo_mode
                ? array_values(array_intersect($this->requestedLists($payload), $configured))
                : $configured;

            if ([] === $listIds) {
                return $this->result($wantsJson, 'choose', 400, $back);
            }

            $apiKey = $this->apiKey();
            $templateId = (int) $module->brevo_doi_template;

            if ('' === $apiKey || $templateId < 1 || '' === $redirect) {
                $missing = array_keys(array_filter(['API key' => '' === $apiKey, 'DOI template' => $templateId < 1, 'confirmation page' => '' === $redirect]));
                $this->systemLog($module, 'the module is not complete (missing: '.implode(', ', $missing).')');

                return $this->result($wantsJson, 'not_configured', 503, $back);
            }

            $ok = $this->brevo->createDoiContact($apiKey, $email, $listIds, $templateId, $redirect);

            if (!$ok) {
                $this->systemLog($module, 'Brevo refused it ('.$this->brevo->lastError().')');
            }
        } catch (\Throwable $e) {
            // Without this line the operator only sees the generic error message and an
            // empty log. The e-mail address is left out on purpose.
            $this->logger?->error('Brevo sign-up failed: '.$e->getMessage(), ['exception' => $e]);
            $this->systemLog($module, mb_substr($e->getMessage(), 0, 300));

            return $this->result($wantsJson, 'send_failed', 502, $back);
        }

        return $this->result($wantsJson, $ok ? 'ok' : 'send_failed', $ok ? 200 : 502, $back);
    }

    /** System › System log: the visitor was not subscribed (without the visitor's address). */
    private function systemLog(ModuleModel|null $module, string $reason): void
    {
        $where = null === $module ? '' : ' in the module "'.$module->name.'" (ID '.(int) $module->id.')';

        $this->contaoErrorLog?->error('Brevo newsletter: a sign-up'.$where.' failed, the visitor was not subscribed: '.$reason.'.');
    }

    /**
     * @param array<string, mixed> $payload
     *
     * @return list<int>
     */
    private function requestedLists(array $payload): array
    {
        $raw = $payload['lists'] ?? [];
        $raw = \is_array($raw) ? $raw : [$raw];

        return array_values(array_filter(array_map('intval', $raw)));
    }

    private function apiKey(): string
    {
        return $this->apiKeys->resolve();
    }

    private function redirectUrl(int $pageId): string
    {
        if ($pageId < 1) {
            return '';
        }

        $page = $this->framework->getAdapter(PageModel::class)->findByPk($pageId);

        if (!$page instanceof PageModel) {
            return '';
        }

        try {
            return $this->urls->generate($page, [], UrlGeneratorInterface::ABSOLUTE_URL);
        } catch (\Throwable) {
            return '';
        }
    }

    /** Same-host referrer (the form page) for the no-JS bounce; '' if absent or cross-host. */
    private function backUrl(Request $request): string
    {
        $ref = (string) $request->headers->get('referer');

        return ('' !== $ref && parse_url($ref, PHP_URL_HOST) === $request->getHost()) ? $ref : '';
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(Request $request): array
    {
        if (str_contains((string) $request->headers->get('Content-Type'), 'application/json')) {
            $data = json_decode((string) $request->getContent(), true);

            return \is_array($data) ? $data : [];
        }

        return $request->request->all();
    }

    private function result(bool $wantsJson, string $status, int $code, ?string $bounce = null): Response
    {
        if ($wantsJson) {
            return new JsonResponse(['status' => $status, 'ok' => 'ok' === $status], $code);
        }

        // Progressive-enhancement fallback (no JS): bounce back to the form page.
        if (null !== $bounce && '' !== $bounce) {
            $glue = str_contains($bounce, '?') ? '&' : '?';

            return new RedirectResponse($bounce.$glue.'nl='.$status);
        }

        return new Response('ok' === $status ? 'OK' : 'Error', 'ok' === $status ? 200 : $code);
    }
}
