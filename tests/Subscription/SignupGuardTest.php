<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Subscription;

use Neo\BrevoNewsletterBundle\Subscription\SignupGuard;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

final class SignupGuardTest extends TestCase
{
    private const NOW = 1_800_000_000;

    public function testAnAddressIsRememberedOnlyAsAHash(): void
    {
        $cache = new ArrayAdapter();
        $guard = new SignupGuard($cache, 'secret');

        $this->assertFalse($guard->addressSeen('max@example.com'));
        $guard->record('max@example.com');

        $this->assertTrue($guard->addressSeen(' MAX@example.com '));
        $this->assertFalse($guard->addressSeen('erika@example.com'));
        $this->assertStringNotContainsString('max@example.com', serialize($cache->getValues()).implode(',', array_keys($cache->getValues())));
    }

    public function testAVisitorHasTwoSignUpsAnHourAndThreeADay(): void
    {
        $guard = new SignupGuard(new ArrayAdapter(), 'secret');
        $hour = 3600;

        $guard->record('a@example.com', '192.0.2.1', 5, self::NOW);
        $this->assertFalse($guard->clientExhausted('192.0.2.1', self::NOW));
        $guard->record('b@example.com', '192.0.2.1', 5, self::NOW);
        $this->assertTrue($guard->clientExhausted('192.0.2.1', self::NOW));
        $this->assertFalse($guard->clientExhausted('192.0.2.2', self::NOW), 'another visitor');

        // The next clock hour: one more, then the day is used up.
        $later = self::NOW - (self::NOW % $hour) + $hour + 60;
        if (date('Ymd', $later) === date('Ymd', self::NOW)) {
            $this->assertFalse($guard->clientExhausted('192.0.2.1', $later));
            $guard->record('c@example.com', '192.0.2.1', 5, $later);
            $this->assertTrue($guard->clientExhausted('192.0.2.1', $later));
        }
    }

    public function testTheModuleLimitCountsAllVisitorsTogether(): void
    {
        $guard = new SignupGuard(new ArrayAdapter(), 'secret');

        $guard->record('a@example.com', '192.0.2.1', 5, self::NOW);
        $guard->record('b@example.com', '192.0.2.2', 5, self::NOW);

        $this->assertSame('', $guard->moduleExhausted(5, 3, 10, self::NOW));
        $this->assertSame('hour', $guard->moduleExhausted(5, 2, 10, self::NOW));
        $this->assertSame('day', $guard->moduleExhausted(5, 0, 2, self::NOW));
        $this->assertSame('', $guard->moduleExhausted(5, 0, 0, self::NOW), '0 = no limit');
        $this->assertSame('', $guard->moduleExhausted(6, 1, 1, self::NOW), 'another module');
    }

    public function testTheOperatorIsToldOnceAnHour(): void
    {
        $guard = new SignupGuard(new ArrayAdapter(), 'secret');

        $this->assertTrue($guard->firstRefusalThisHour(5, self::NOW));
        $this->assertFalse($guard->firstRefusalThisHour(5, self::NOW + 10));
        $this->assertTrue($guard->firstRefusalThisHour(6, self::NOW));
    }
}
