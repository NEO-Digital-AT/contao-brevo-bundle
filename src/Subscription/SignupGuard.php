<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Subscription;

use Psr\Cache\CacheItemPoolInterface;

/**
 * Limits on sign-ups that Brevo has accepted, i.e. on confirmation e-mails sent.
 * Built against "subscription bombing": bots enter the addresses of real people on
 * many websites at once, so that the victims drown in confirmation e-mails. Each
 * of those e-mails costs the operator sending quota and sender reputation.
 *
 *  - Per address: one confirmation e-mail per ADDRESS_HOURS. A repeat in that time
 *    sends nothing. The address is kept only as a keyed hash (HMAC with the
 *    application secret), never in plain text.
 *  - Per visitor (client IP, also only as a hash): CLIENT_PER_HOUR sign-ups an
 *    hour and CLIENT_PER_DAY a day, so one visitor cannot enter a list of
 *    addresses.
 *  - Per module, for all visitors together: the limits set in the module
 *    (sign-ups an hour / a day, 0 = no limit). That is the ceiling when bots
 *    change their IP address for every request.
 *
 * Counters live in the application cache in fixed windows (clock hour, calendar
 * day); nothing is stored in the database.
 */
final class SignupGuard
{
    public const ADDRESS_HOURS = 24;
    public const CLIENT_PER_HOUR = 2;
    public const CLIENT_PER_DAY = 3;

    /** Defaults of the module fields "sign-ups per hour / per day". */
    public const MODULE_PER_HOUR = 5;
    public const MODULE_PER_DAY = 20;

    private const PREFIX = 'neo_brevo_guard_';

    public function __construct(
        private readonly CacheItemPoolInterface $cache,
        private readonly string $secret,
    ) {
    }

    /** A confirmation e-mail went to this address within the last ADDRESS_HOURS. */
    public function addressSeen(string $email): bool
    {
        return $this->cache->getItem($this->addressKey($email))->isHit();
    }

    /** A visitor has used up the sign-ups allowed to them. */
    public function clientExhausted(string $client, int|null $now = null): bool
    {
        $now ??= time();

        return $this->count('c_h_'.$this->hash($client).'_'.date('YmdH', $now)) >= self::CLIENT_PER_HOUR
            || $this->count('c_d_'.$this->hash($client).'_'.date('Ymd', $now)) >= self::CLIENT_PER_DAY;
    }

    /**
     * The module's limit for all visitors together is reached.
     *
     * @return string '' if there is room, otherwise 'hour' or 'day'
     */
    public function moduleExhausted(int $moduleId, int $perHour, int $perDay, int|null $now = null): string
    {
        $now ??= time();

        if ($perHour > 0 && $this->count('m_h_'.$moduleId.'_'.date('YmdH', $now)) >= $perHour) {
            return 'hour';
        }

        if ($perDay > 0 && $this->count('m_d_'.$moduleId.'_'.date('Ymd', $now)) >= $perDay) {
            return 'day';
        }

        return '';
    }

    /**
     * Counts a sign-up that Brevo accepted. $moduleId 0 = not from a module
     * (form generator): only the address is remembered.
     */
    public function record(string $email, string $client = '', int $moduleId = 0, int|null $now = null): void
    {
        $now ??= time();

        $item = $this->cache->getItem($this->addressKey($email));
        $this->cache->save($item->set(1)->expiresAfter(self::ADDRESS_HOURS * 3600));

        if ('' !== $client) {
            $this->increment('c_h_'.$this->hash($client).'_'.date('YmdH', $now), 3700);
            $this->increment('c_d_'.$this->hash($client).'_'.date('Ymd', $now), 90000);
        }

        if ($moduleId > 0) {
            $this->increment('m_h_'.$moduleId.'_'.date('YmdH', $now), 3700);
            $this->increment('m_d_'.$moduleId.'_'.date('Ymd', $now), 90000);
        }
    }

    /**
     * True only the first time a module's limit is hit within the current hour, so
     * the system log gets one line per hour, not one per refused sign-up.
     */
    public function firstRefusalThisHour(int $moduleId, int|null $now = null): bool
    {
        $item = $this->cache->getItem(self::PREFIX.'m_log_'.$moduleId.'_'.date('YmdH', $now ?? time()));

        if ($item->isHit()) {
            return false;
        }

        $this->cache->save($item->set(1)->expiresAfter(3700));

        return true;
    }

    private function count(string $key): int
    {
        $item = $this->cache->getItem(self::PREFIX.$key);

        return $item->isHit() ? (int) $item->get() : 0;
    }

    private function increment(string $key, int $ttl): void
    {
        $item = $this->cache->getItem(self::PREFIX.$key);
        $this->cache->save($item->set(($item->isHit() ? (int) $item->get() : 0) + 1)->expiresAfter($ttl));
    }

    private function addressKey(string $email): string
    {
        return self::PREFIX.'a_'.$this->hash(mb_strtolower(trim($email)));
    }

    private function hash(string $value): string
    {
        return hash_hmac('sha256', $value, 'neo_brevo_guard|'.$this->secret);
    }
}
