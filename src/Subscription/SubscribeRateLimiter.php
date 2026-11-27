<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Subscription;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\CacheStorage;

/**
 * Per-client sliding-window limit on ATTEMPTS at the subscribe endpoint (valid or
 * not), backed by the application cache: LIMIT in INTERVAL. Sign-ups that Brevo
 * accepted are limited separately (SignupGuard). The client key is stored only as
 * a hash. Self-contained so the bundle needs no host-side framework.rate_limiter
 * configuration.
 */
final class SubscribeRateLimiter
{
    public const LIMIT = 5;
    public const INTERVAL = '10 minutes';

    private readonly RateLimiterFactory $factory;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->factory = new RateLimiterFactory(
            [
                'id' => 'neo_brevo_newsletter',
                'policy' => 'sliding_window',
                'limit' => self::LIMIT,
                'interval' => self::INTERVAL,
            ],
            new CacheStorage($cache),
        );
    }

    public function accept(string $key): bool
    {
        return $this->factory->create(hash('sha256', $key))->consume(1)->isAccepted();
    }
}
