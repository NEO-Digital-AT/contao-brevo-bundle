<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Brevo;

/**
 * Where first and last name go in Brevo. The module can name the attribute; left
 * empty ("automatic"), the bundle takes the default attribute of the account:
 * Brevo creates it in the language of the account (FIRSTNAME in English, VORNAME
 * in German, PRENOM in French, …).
 */
final class NameAttributes
{
    /** Default attribute names of Brevo accounts, most common first. */
    public const FIRST = ['FIRSTNAME', 'VORNAME', 'PRENOM', 'NOMBRE', 'NOME', 'VOORNAAM', 'IMIE', 'JMENO', 'IME', 'KERESZTNEV', 'FNAME'];
    public const LAST = ['LASTNAME', 'NACHNAME', 'NOM', 'APELLIDOS', 'COGNOME', 'ACHTERNAAM', 'NAZWISKO', 'PRIJMENI', 'PREZIME', 'PRIIMEK', 'VEZETEKNEV', 'LNAME'];

    /**
     * @param array<string, string> $available attributes of the account (BrevoClient::getAttributes)
     * @param list<string>          $candidates self::FIRST or self::LAST
     *
     * @return string the attribute, '' if the account has none of the defaults
     */
    public static function resolve(string $configured, array $available, array $candidates): string
    {
        $configured = strtoupper(trim($configured));

        if ('' !== $configured) {
            return $configured;
        }

        // Without an answer from Brevo: the English default, Brevo's own.
        if ([] === $available) {
            return $candidates[0];
        }

        $names = array_map('strtoupper', array_keys($available));

        foreach ($candidates as $candidate) {
            if (\in_array($candidate, $names, true)) {
                return $candidate;
            }
        }

        return '';
    }
}
