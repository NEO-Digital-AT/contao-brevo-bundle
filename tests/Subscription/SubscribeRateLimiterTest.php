<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Subscription;

use Neo\BrevoNewsletterBundle\Subscription\SubscribeRateLimiter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

final class SubscribeRateLimiterTest extends TestCase
{
    public function testEightSignUpsAMinutePerClient(): void
    {
        $limiter = new SubscribeRateLimiter(new ArrayAdapter());

        for ($i = 1; $i <= 8; ++$i) {
            $this->assertTrue($limiter->accept('nl-192.0.2.1'), 'attempt '.$i);
        }

        $this->assertFalse($limiter->accept('nl-192.0.2.1'));
        $this->assertTrue($limiter->accept('nl-192.0.2.2'), 'another client');
    }
}
