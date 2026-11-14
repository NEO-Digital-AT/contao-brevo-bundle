<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Migration;

use Contao\Config;
use Contao\CoreBundle\Framework\Adapter;
use Contao\CoreBundle\Framework\ContaoFramework;
use Doctrine\DBAL\Connection;
use Neo\BasicBundle\Security\SecretCipher;
use Neo\BrevoNewsletterBundle\Migration\AdoptApiKeyMigration;
use Neo\BrevoNewsletterBundle\Tests\Support\Database;
use Neo\BrevoNewsletterBundle\Tests\Support\LegacySettings;
use PHPUnit\Framework\TestCase;

final class AdoptApiKeyMigrationTest extends TestCase
{
    private Connection $db;

    private SecretCipher $cipher;

    protected function setUp(): void
    {
        $this->db = Database::connection();
        $this->cipher = new SecretCipher(Database::SECRET);
        LegacySettings::$brevoApiKey = $this->cipher->encrypt('xkeysib-legacy', AdoptApiKeyMigration::LEGACY_SCOPE);
    }

    public function testTheKeyOfTheSettingsIsTakenOverOnce(): void
    {
        $migration = $this->migration();

        $this->assertTrue($migration->shouldRun());
        $this->assertTrue($migration->run()->isSuccessful());

        $settings = Database::settings($this->db);
        $this->assertSame('xkeysib-legacy', $settings->secret('brevo_api_key'));
        $this->assertStringStartsWith('enc:', (string) $this->db->fetchOne('SELECT brevo_api_key FROM tl_neo_access'));
        $this->assertTrue($settings->isAdopted('brevo_settings'));
        $this->assertFalse($this->migration()->shouldRun());
    }

    public function testAKeyRemovedLaterDoesNotComeBack(): void
    {
        $this->migration()->run();
        Database::settings($this->db)->store(['brevo_api_key' => '']);

        $this->assertFalse($this->migration()->shouldRun());
    }

    public function testAKeyAlreadyStoredIsNotOverwritten(): void
    {
        Database::settings($this->db, 'xkeysib-current');

        $result = $this->migration()->run();

        $this->assertStringContainsString('already stored', $result->getMessage());
        $this->assertSame('xkeysib-current', Database::settings($this->db)->secret('brevo_api_key'));
        $this->assertFalse($this->migration()->shouldRun());
    }

    public function testNothingToTakeOver(): void
    {
        LegacySettings::$brevoApiKey = '';
        $this->assertFalse($this->migration()->shouldRun());

        LegacySettings::$brevoApiKey = (new SecretCipher('another-app-secret'))->encrypt('xkeysib-legacy', AdoptApiKeyMigration::LEGACY_SCOPE);
        $this->assertFalse($this->migration()->shouldRun(), 'cannot be decrypted');
    }

    public function testWaitsForTheColumnOfTheDatabaseUpdate(): void
    {
        $this->db = Database::connection(false);

        $this->assertFalse($this->migration()->shouldRun());
    }

    private function migration(): AdoptApiKeyMigration
    {
        $framework = $this->createStub(ContaoFramework::class);
        $framework->method('getAdapter')->willReturnCallback(fn (string $class): Adapter => match ($class) {
            Config::class => new Adapter(LegacySettings::class),
        });

        return new AdoptApiKeyMigration($framework, Database::settings($this->db), $this->cipher);
    }
}

