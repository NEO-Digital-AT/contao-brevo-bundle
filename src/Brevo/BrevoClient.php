<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Brevo;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Thin wrapper around the Brevo (formerly Sendinblue) REST API v3 — only the two
 * calls this bundle needs: list the account's contact lists (for the back-end
 * selection and the front-end labels) and create a contact via the double-opt-in
 * flow (Brevo sends the confirmation e-mail and adds the contact once confirmed).
 *
 * getLists() is cached and never throws, so it is safe to call from a DCA
 * options_callback and on every front-end render. createDoiContact() reports
 * success/failure for the subscribe endpoint to handle.
 *
 * @see https://developers.brevo.com/reference/getlists-1
 * @see https://developers.brevo.com/reference/create-doi-contact
 */
final class BrevoClient
{
    private const BASE = 'https://api.brevo.com/v3';
    private const LIST_TTL = 3600;

    /** Brevo's reason for the last refused createDoiContact() call, without the address. */
    private string $lastError = '';

    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly CacheItemPoolInterface $cache,
        private readonly LoggerInterface|null $logger = null,
    ) {
    }

    /**
     * Returns the account's contact lists as [id => name], cached for an hour and
     * resilient (empty array on a missing key or any API/transport error).
     *
     * @return array<int, string>
     */
    public function getLists(string $apiKey, int $limit = 50): array
    {
        if ('' === $apiKey) {
            return [];
        }

        $item = $this->cache->getItem('neo_brevo_lists_'.hash('sha256', $apiKey));

        if ($item->isHit()) {
            return $item->get();
        }

        $lists = $this->fetchLists($apiKey, $limit);

        // Cache successes for an hour; back off only briefly on failure so a fixed
        // key is picked up soon without hammering the API.
        $item->set($lists)->expiresAfter([] === $lists ? 60 : self::LIST_TTL);
        $this->cache->save($item);

        return $lists;
    }

    /**
     * Returns the account's transactional e-mail templates as [id => "name (id)"],
     * cached for an hour and resilient (empty array on any error). Used to pick the
     * double-opt-in template in the back end instead of typing an ID.
     *
     * @return array<int, string>
     */
    public function getTemplates(string $apiKey, int $limit = 100): array
    {
        if ('' === $apiKey) {
            return [];
        }

        $item = $this->cache->getItem('neo_brevo_templates_'.hash('sha256', $apiKey));

        if ($item->isHit()) {
            return $item->get();
        }

        $templates = $this->fetchTemplates($apiKey, $limit);

        $item->set($templates)->expiresAfter([] === $templates ? 60 : self::LIST_TTL);
        $this->cache->save($item);

        return $templates;
    }

    /**
     * Creates/updates a contact through Brevo's double-opt-in flow. Brevo sends the
     * DOI confirmation e-mail using $templateId and, on confirmation, adds the
     * contact to $listIds and redirects to $redirectUrl.
     *
     * @param list<int>            $listIds
     * @param array<string, mixed> $attributes
     *
     * @return bool true if Brevo accepted the request (2xx); on false, lastError() says why
     */
    public function createDoiContact(
        string $apiKey,
        string $email,
        array $listIds,
        int $templateId,
        string $redirectUrl,
        array $attributes = [],
    ): bool {
        $this->lastError = '';

        $body = [
            'email' => $email,
            'includeListIds' => array_values(array_map('intval', $listIds)),
            'templateId' => $templateId,
            'redirectionUrl' => $redirectUrl,
        ];

        if ([] !== $attributes) {
            $body['attributes'] = $attributes;
        }

        $response = $this->httpClient->request('POST', self::BASE.'/contacts/doubleOptinConfirmation', [
            'headers' => [
                'api-key' => $apiKey,
                'content-type' => 'application/json',
                'accept' => 'application/json',
            ],
            'json' => $body,
        ]);

        $status = $response->getStatusCode();

        // 201 Created / 204 No Content (already a contact, DOI re-sent) are success.
        if ($status >= 200 && $status < 300) {
            return true;
        }

        // Brevo's error message MUST go into the log — without it the operator only sees
        // the generic error message and has no clue what is wrong (e.g. invalid redirect
        // URL, template is not a double-opt-in template, sender not verified). The
        // subscriber's e-mail address is deliberately NOT logged.
        $error = $response->toArray(false);
        $message = trim((string) ($error['message'] ?? $error['code'] ?? ''));
        $this->lastError = 'HTTP '.$status.('' === $message ? '' : ': '.mb_substr($message, 0, 300));

        $this->logger?->error(\sprintf(
            'Brevo rejected the sign-up (HTTP %d): %s [code=%s, templateId=%d, listIds=%s, redirectionUrl=%s]',
            $status,
            (string) ($error['message'] ?? 'no message'),
            (string) ($error['code'] ?? '-'),
            $templateId,
            implode(',', $body['includeListIds']),
            $redirectUrl,
        ));

        return false;
    }

    /**
     * Why Brevo refused the last createDoiContact() call ("HTTP 400: …"), for the
     * system log; empty after an accepted call. Never contains the e-mail address.
     */
    public function lastError(): string
    {
        return $this->lastError;
    }

    /**
     * @return array<int, string>
     */
    private function fetchLists(string $apiKey, int $limit): array
    {
        try {
            $response = $this->httpClient->request('GET', self::BASE.'/contacts/lists', [
                'headers' => ['api-key' => $apiKey, 'accept' => 'application/json'],
                'query' => ['limit' => $limit, 'offset' => 0, 'sort' => 'desc'],
            ]);

            $data = $response->toArray(false);
        } catch (\Throwable) {
            return [];
        }

        $lists = [];

        foreach ($data['lists'] ?? [] as $list) {
            if (isset($list['id'], $list['name'])) {
                $lists[(int) $list['id']] = (string) $list['name'];
            }
        }

        return $lists;
    }

    /**
     * @return array<int, string>
     */
    private function fetchTemplates(string $apiKey, int $limit): array
    {
        try {
            $response = $this->httpClient->request('GET', self::BASE.'/smtp/templates', [
                'headers' => ['api-key' => $apiKey, 'accept' => 'application/json'],
                'query' => ['limit' => $limit, 'offset' => 0, 'sort' => 'asc'],
            ]);

            $data = $response->toArray(false);
        } catch (\Throwable) {
            return [];
        }

        $templates = [];

        foreach ($data['templates'] ?? [] as $tpl) {
            if (!isset($tpl['id'], $tpl['name'])) {
                continue;
            }

            $label = (string) $tpl['name'].' (#'.(int) $tpl['id'].')';

            if (isset($tpl['isActive']) && !$tpl['isActive']) {
                $label .= ' – inactive';
            }

            $templates[(int) $tpl['id']] = $label;
        }

        return $templates;
    }
}
