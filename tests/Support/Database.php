<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Support;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Neo\BasicBundle\Access\AccessSettings;
use Neo\BasicBundle\Security\SecretCipher;

/**
 * An SQLite database in memory with the columns this bundle reads: its key
 * on "Access keys and licences" (Basic bundle) and its fields in tl_module and
 * tl_form_field.
 */
final class Database
{
    public const SECRET = 'app-secret-for-tests';

    public static function connection(bool $withKeyColumn = true): Connection
    {
        $db = DriverManager::getConnection(['driver' => 'pdo_sqlite', 'memory' => true]);

        $db->executeStatement('CREATE TABLE tl_neo_access (id INTEGER PRIMARY KEY AUTOINCREMENT, tstamp INTEGER NOT NULL DEFAULT 0, adopted VARCHAR(255) NOT NULL DEFAULT \'\''.($withKeyColumn ? ', brevo_api_key VARCHAR(1024) NOT NULL DEFAULT \'\'' : '').')');

        foreach (['tl_module', 'tl_form_field'] as $table) {
            $db->executeStatement("CREATE TABLE {$table} (id INTEGER PRIMARY KEY AUTOINCREMENT, type VARCHAR(64) NOT NULL DEFAULT '', brevo_lists BLOB NULL, brevo_doi_template INTEGER NOT NULL DEFAULT 0, brevo_mode VARCHAR(16) NOT NULL DEFAULT 'fixed')");
        }

        return $db;
    }

    public static function settings(Connection $db, string $key = ''): AccessSettings
    {
        $settings = new AccessSettings($db, new SecretCipher(self::SECRET));

        if ('' !== $key) {
            $settings->store(['brevo_api_key' => $key], ['brevo_api_key']);
        }

        return $settings;
    }
}
