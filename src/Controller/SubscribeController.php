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
use Neo\BrevoNewsletterBundle\Subscription\ContactFields;
use Neo\BrevoNewsletterBundle\Subscription\ProofOfWork;
use Neo\BrevoNewsletterBundle\Subscription\SignupGuard;
use Neo\BrevoNewsletterBundle\Subscription\SubscribeRateLimiter;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Front-end endpoints of the newsletter sign-up:
 *  - GET  /api/brevo/challenge: a proof-of-work task for the spam protection;
 *  - POST /api/brevo/subscribe: the sign-up.
 *
 * The API key is the one on "Access keys and licences" of the Basic bundle
 * (ApiKeyResolver, with the BREVO_API_KEY environment variable as fallback); the
 * opt-in template, confirmation page and authorised list(s) come from the
 * front-end module named in the request (so one key drives many sign-up
 * modules). In "fixed" mode the contact is added to all configured
 * lists; in "choice" mode only to the visitor's selection intersected with the
 * configured lists (never trusted from the client).
 *
 * Spam protection, in this order (docs/en/usage.md, "Spam protection"):
 *  1. attempts per visitor (SubscribeRateLimiter);
 *  2. hidden field (honeypot), requests from other websites and from obvious
 *     scripts (curl, Python, headless browsers …);
 *  3. the solved proof-of-work task (ProofOfWork);
 *  4. one confirmation e-mail per address in 24 hours, sign-ups per visitor and
 *     the module's limit for all visitors together (SignupGuard).
 * The e-mail address is not persisted or logged; the guard keeps a keyed hash.
 *
 * A sign-up that does not reach Brevo (module incomplete, Brevo refuses it, no
 * connection) is an error in Contao's system log (System › System log), so the
 * operator sees it; the application log keeps Brevo's full answer. So is a
 * module limit that is reached (once an hour): that is what an attack looks like.
 */
final class SubscribeController extends AbstractController
{
    /** User agents of scripts and automated browsers, never of a person's browser. */
    private const AUTOMATED = '/headlesschrome|phantomjs|selenium|puppeteer|playwright|\\bbot\\b|crawler|spider|scrapy|curl\\/|wget|python|go-http|node-fetch|undici|axios|okhttp|java\\/|libwww|httpclient|guzzle|postman|insomnia/i';

    public function __construct(
        private readonly ContaoFramework $framework,
        private readonly BrevoClient $brevo,
        private readonly ApiKeyResolver $apiKeys,
        private readonly SubscribeRateLimiter $limiter,
        private readonly ContentUrlGenerator $urls,
        private readonly ProofOfWork $proofOfWork,
        private readonly SignupGuard $guard,
        private readonly LoggerInterface|null $logger = null,
        private readonly LoggerInterface|null $contaoErrorLog = null,
    ) {
    }

    /** GET /api/brevo/challenge — never cached, a new task on every call. */
    public function challenge(): JsonResponse
    {
        $response = new JsonResponse($this->proofOfWork->challenge());
        $response->setPrivate();
        $response->headers->set('Cache-Control', 'no-store, private');
        $response->headers->set('X-Robots-Tag', 'noindex');

        return $response;
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
        $client = (string) $request->getClientIp();

        try {
            if (!$this->limiter->accept('nl-'.$client)) {
                return $this->result($wantsJson, 'rate_limited', 429, $back);
            }

            // Honeypot: a real user never fills this hidden field. Requests from another
            // website or from a script are no sign-ups of a visitor either.
            if ('' !== trim((string) ($payload['website'] ?? '')) || $this->foreign($request) || $this->automated($request)) {
                return $this->result($wantsJson, 'invalid', 400, $back);
            }

            $email = filter_var(trim((string) ($payload['email'] ?? '')), FILTER_VALIDATE_EMAIL);
            $consent = \in_array($payload['consent'] ?? null, [true, '1', 'on', 1], true);
            $module = $this->framework->getAdapter(ModuleModel::class)->findByPk((int) ($payload['mod'] ?? 0));

            if (false === $email || !$consent || null === $module || 'brevo_newsletter' !== $module->type) {
                return $this->result($wantsJson, 'invalid', 400, $back);
            }

            // Additional fields switched on in the module; others are ignored.
            $values = $this->fieldValues($module, $payload);

            if (\is_string($values)) {
                return $this->result($wantsJson, $values, 400, $back);
            }

            // Before anything that reveals whether the address is known: only a solved
            // task gets that far.
            if ('' !== $this->proofOfWork->verify((string) ($payload['altcha'] ?? ''))) {
                return $this->result($wantsJson, 'verify', 400, $back);
            }

            // One confirmation e-mail per address in 24 hours: a repeat sends nothing.
            if ($this->guard->addressSeen($email)) {
                return $this->result($wantsJson, 'repeat', 409, $back);
            }

            if ($this->guard->clientExhausted($client)) {
                return $this->result($wantsJson, 'rate_limited', 429, $back);
            }

            $perHour = $this->limit($module->brevo_limit_hour, SignupGuard::MODULE_PER_HOUR);
            $perDay = $this->limit($module->brevo_limit_day, SignupGuard::MODULE_PER_DAY);
            $full = $this->guard->moduleExhausted((int) $module->id, $perHour, $perDay);

            if ('' !== $full) {
                if ($this->guard->firstRefusalThisHour((int) $module->id)) {
                    $this->systemLog($module, 'hour' === $full
                        ? \sprintf('the limit of %d sign-ups an hour is reached, further sign-ups are refused until the next full hour. Many sign-ups in a short time are typical of bots that enter other people\'s addresses', $perHour)
                        : \sprintf('the limit of %d sign-ups a day is reached, further sign-ups are refused until midnight. Many sign-ups in a short time are typical of bots that enter other people\'s addresses', $perDay));
                }

                return $this->result($wantsJson, 'rate_limited', 429, $back);
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

            $attributes = $this->attributes($module, $apiKey, $values);
            $ok = $this->brevo->createDoiContact($apiKey, $email, $listIds, $templateId, $redirect, $attributes);

            // The sign-up matters more than the name: if Brevo refuses the attributes
            // (e.g. an attribute the account does not have), once more without them.
            if (!$ok && [] !== $attributes) {
                $this->systemLog($module, 'Brevo refused the attributes '.implode(', ', array_keys($attributes)).' ('.$this->brevo->lastError().'); the visitor is signed up without them');
                $ok = $this->brevo->createDoiContact($apiKey, $email, $listIds, $templateId, $redirect);
            }

            if ($ok) {
                $this->guard->record($email, $client, (int) $module->id);
            } else {
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

    /**
     * The values of the module's additional fields, or the status of the error:
     * 'fields' (a required field is empty), 'phone' (not in international format).
     *
     * @param array<string, mixed> $payload
     *
     * @return array<string, string>|string
     */
    private function fieldValues(ModuleModel $module, array $payload): array|string
    {
        $sent = \is_array($payload['fields'] ?? null) ? $payload['fields'] : [];
        $enabled = ContactFields::enabled(StringUtil::deserialize($module->brevo_fields, true));
        $required = StringUtil::deserialize($module->brevo_fields_required, true);
        $values = [];

        foreach ($enabled as $key) {
            $value = ContactFields::clean($sent[$key] ?? '');

            if ('' === $value) {
                if (\in_array($key, $required, true)) {
                    return 'fields';
                }

                continue;
            }

            if (ContactFields::isPhone($key)) {
                $value = ContactFields::phone($value);

                if ('' === $value) {
                    return 'phone';
                }
            }

            $values[$key] = $value;
        }

        return $values;
    }

    /**
     * @param array<string, string> $values
     *
     * @return array<string, string>
     */
    private function attributes(ModuleModel $module, string $apiKey, array $values): array
    {
        if ([] === $values) {
            return [];
        }

        $first = (string) $module->brevo_attr_firstname;
        $last = (string) $module->brevo_attr_lastname;
        // The account's attributes are only needed to find the automatic name attributes.
        $automatic = (isset($values['firstname']) && '' === trim($first)) || (isset($values['lastname']) && '' === trim($last));

        return ContactFields::attributes($values, $first, $last, $automatic ? $this->brevo->getAttributes($apiKey) : []);
    }

    /** Empty field (module saved before 1.1.0) = default; 0 = no limit. */
    private function limit(mixed $value, int $default): int
    {
        return null === $value || '' === $value ? $default : max(0, (int) $value);
    }

    /** Sent from another website (the browser says so). */
    private function foreign(Request $request): bool
    {
        if ('cross-site' === $request->headers->get('Sec-Fetch-Site')) {
            return true;
        }

        $origin = (string) $request->headers->get('Origin');

        return '' !== $origin && 'null' !== $origin && parse_url($origin, PHP_URL_HOST) !== $request->getHost();
    }

    /** No user agent, or the one of a script or automated browser. */
    private function automated(Request $request): bool
    {
        $agent = trim((string) $request->headers->get('User-Agent'));

        return '' === $agent || 1 === preg_match(self::AUTOMATED, $agent);
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
