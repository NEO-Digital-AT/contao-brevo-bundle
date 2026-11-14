<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Subscription;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\RateLimiter\Storage\CacheStorage;

/**
 * Per-client sliding-window rate limit for the subscribe endpoint, backed by the
 * application cache. Self-contained so the bundle needs no host-side
 * framework.rate_limiter configuration.
 */
final class SubscribeRateLimiter
{
    private readonly RateLimiterFactory $factory;

    public function __construct(CacheItemPoolInterface $cache)
    {
        $this->factory = new RateLimiterFactory(
            [
                'id' => 'neo_brevo_newsletter',
                'policy' => 'sliding_window',
                'limit' => 8,
                'interval' => '1 minute',
            ],
            new CacheStorage($cache),
        );
    }

    public function accept(string $key): bool
    {
        return $this->factory->create($key)->consume(1)->isAccepted();
    }
}
