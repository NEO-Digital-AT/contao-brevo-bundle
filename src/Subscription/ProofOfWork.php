<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Subscription;

use Psr\Cache\CacheItemPoolInterface;

/**
 * Invisible spam protection of the sign-up: a proof-of-work task in the format of
 * ALTCHA (https://altcha.org), built in and always on.
 *
 * GET /api/brevo/challenge hands out a task: find the number N (0 … maxnumber) for
 * which SHA-256(salt + N) equals the challenge. The visitor's browser solves it in
 * the background while the address is typed (public/brevo-newsletter.js) and sends
 * the solution with the sign-up. A real visitor does not notice anything; a bot
 * that posts straight to the endpoint has no solution, and one that solves it has
 * to spend computing time on every single address.
 *
 * Self-contained on purpose (no dependency on Contao's internal ALTCHA service),
 * so it runs the same on Contao 5.3 to 6. A solution
 *  - is signed (HMAC with the application secret), so it cannot be forged;
 *  - expires after LIFETIME seconds;
 *  - is only accepted MIN_AGE seconds after the task was handed out (a person needs
 *    longer than that to type an address; the script waits for it);
 *  - counts once: a solved task is remembered until it expires (no replay).
 */
final class ProofOfWork
{
    public const ALGORITHM = 'SHA-256';

    /** Upper bound of the number to find; on average the browser tries half of it. */
    public const MAX_NUMBER = 100000;

    /** Seconds a task stays valid. */
    public const LIFETIME = 3600;

    /** Seconds between handing out a task and accepting its solution. */
    public const MIN_AGE = 2;

    private const REPLAY_PREFIX = 'neo_brevo_pow_';

    public function __construct(
        private readonly CacheItemPoolInterface $cache,
        private readonly string $secret,
        private readonly int $maxNumber = self::MAX_NUMBER,
    ) {
    }

    /**
     * A new task in ALTCHA's format, plus the upper bound of the number.
     *
     * @return array{algorithm: string, challenge: string, salt: string, signature: string, maxnumber: int}
     */
    public function challenge(int|null $now = null): array
    {
        $now ??= time();
        $salt = bin2hex(random_bytes(12)).'?expires='.($now + self::LIFETIME).'&issued='.$now.'&';
        $challenge = hash('sha256', $salt.random_int(0, $this->maxNumber));

        return [
            'algorithm' => self::ALGORITHM,
            'challenge' => $challenge,
            'salt' => $salt,
            'signature' => $this->sign($challenge),
            'maxnumber' => $this->maxNumber,
        ];
    }

    /**
     * Checks a solution (base64-encoded JSON as ALTCHA sends it) and, if it is
     * valid, uses it up.
     *
     * @return string '' if valid, otherwise the reason: missing, malformed, expired, early, wrong, replay
     */
    public function verify(string $payload, int|null $now = null): string
    {
        $now ??= time();

        if ('' === trim($payload)) {
            return 'missing';
        }

        $decoded = base64_decode($payload, true);
        $data = false === $decoded ? null : json_decode($decoded, true);

        if (!\is_array($data)) {
            return 'malformed';
        }

        foreach (['algorithm', 'challenge', 'number', 'salt', 'signature'] as $key) {
            if (!isset($data[$key]) || !\is_scalar($data[$key])) {
                return 'malformed';
            }
        }

        $salt = (string) $data['salt'];
        $challenge = (string) $data['challenge'];
        $number = filter_var($data['number'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => $this->maxNumber]]);

        if (self::ALGORITHM !== $data['algorithm'] || false === $number) {
            return 'malformed';
        }

        // The signature binds the challenge, and the challenge binds the salt with its
        // times: neither can be changed without the signature failing.
        if (!hash_equals($this->sign($challenge), (string) $data['signature']) || !hash_equals($challenge, hash('sha256', $salt.$number))) {
            return 'wrong';
        }

        parse_str(explode('?', $salt, 2)[1] ?? '', $params);
        $expires = (int) ($params['expires'] ?? 0);
        $issued = (int) ($params['issued'] ?? 0);

        if ($expires < $now) {
            return 'expired';
        }

        if ($issued > $now - self::MIN_AGE) {
            return 'early';
        }

        $item = $this->cache->getItem(self::REPLAY_PREFIX.$challenge);

        if ($item->isHit()) {
            return 'replay';
        }

        $item->set(1)->expiresAfter(max(60, $expires - $now + 60));
        $this->cache->save($item);

        return '';
    }

    private function sign(string $challenge): string
    {
        return hash_hmac('sha256', $challenge, 'neo_brevo_pow|'.$this->secret);
    }
}
