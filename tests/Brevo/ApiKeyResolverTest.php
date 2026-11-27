<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Brevo;

use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Neo\BrevoNewsletterBundle\Tests\Support\Database;
use PHPUnit\Framework\TestCase;

final class ApiKeyResolverTest extends TestCase
{
    protected function tearDown(): void
    {
        unset($_ENV['BREVO_API_KEY'], $_SERVER['BREVO_API_KEY']);
        putenv('BREVO_API_KEY');
    }

    public function testTheKeyOnAccessKeysAndLicencesComesFirst(): void
    {
        $_ENV['BREVO_API_KEY'] = 'from-env';

        $this->assertSame('xkeysib-stored', (new ApiKeyResolver(Database::settings(Database::connection(), 'xkeysib-stored')))->resolve());
    }

    public function testTheEnvironmentVariableIsTheFallback(): void
    {
        $resolver = new ApiKeyResolver(Database::settings(Database::connection()));

        $this->assertSame('', $resolver->resolve());

        putenv('BREVO_API_KEY= from-getenv ');
        $this->assertSame('from-getenv', $resolver->resolve());

        $_SERVER['BREVO_API_KEY'] = 'from-server';
        $this->assertSame('from-server', $resolver->resolve());

        $_ENV['BREVO_API_KEY'] = 'from-env';
        $this->assertSame('from-env', $resolver->resolve());
    }

    public function testTheMcpFormOfTheKeyIsUnwrapped(): void
    {
        $mcp = base64_encode((string) json_encode(['api_key' => 'xkeysib-example-1234']));

        $this->assertSame('xkeysib-example-1234', ApiKeyResolver::unwrap(' '.$mcp.' '));
        $this->assertSame('xkeysib-example-1234', ApiKeyResolver::unwrap(rtrim(strtr($mcp, '+/', '-_'), '=')), 'URL-safe base64');
        $this->assertSame('xkeysib-plain', ApiKeyResolver::unwrap('xkeysib-plain'));
        $this->assertSame('something-else', ApiKeyResolver::unwrap('something-else'), 'unknown forms stay as they are');
    }
}
