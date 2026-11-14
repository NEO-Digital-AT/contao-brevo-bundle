<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Migration;

use Contao\Config;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Migration\AbstractMigration;
use Contao\CoreBundle\Migration\MigrationResult;
use Neo\BasicBundle\Access\AccessSettings;
use Neo\BasicBundle\Security\SecretCipher;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;

/**
 * Earlier versions stored the API key in Contao's settings (localconfig
 * "brevo_api_key", encrypted with the scope below); it now lives on "Access
 * keys and licences" (Basic bundle). An installation without a key there gets
 * the old key once. A key already stored there is not overwritten; the old
 * value in localconfig stays untouched. The run is recorded, so a key removed
 * later does not come back.
 */
final class AdoptApiKeyMigration extends AbstractMigration
{
    /** Scope of the encryption used by earlier versions. */
    public const LEGACY_SCOPE = 'neo-brevo-newsletter';

    private const SOURCE = 'brevo_settings';

    public function __construct(
        private readonly ContaoFramework $framework,
        private readonly AccessSettings $access,
        private readonly SecretCipher $cipher,
    ) {
    }

    public function getName(): string
    {
        return 'Brevo: take over the API key from the settings into "Access keys and licences"';
    }

    public function shouldRun(): bool
    {
        return '' !== $this->legacyKey();
    }

    public function run(): MigrationResult
    {
        $key = $this->legacyKey();

        if ('' === $key) {
            return $this->createResult(true);
        }

        $this->access->markAdopted(self::SOURCE);

        if ($this->access->hasValue(ApiKeyResolver::KEY)) {
            return $this->createResult(true, 'A Brevo API key is already stored; the key from the settings was not taken over.');
        }

        $this->access->store([ApiKeyResolver::KEY => $key], [ApiKeyResolver::KEY]);

        return $this->createResult(true, 'Taken over the Brevo API key from the settings.');
    }

    /** The key of the settings in plain text, '' when there is none, it cannot be decrypted or it was taken over already. */
    private function legacyKey(): string
    {
        if (!$this->access->hasColumns('adopted', ApiKeyResolver::KEY) || $this->access->isAdopted(self::SOURCE)) {
            return '';
        }

        $this->framework->initialize();
        $stored = (string) $this->framework->getAdapter(Config::class)->get('brevo_api_key');

        return trim($this->cipher->decrypt($stored, self::LEGACY_SCOPE));
    }
}
