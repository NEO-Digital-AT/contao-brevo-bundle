<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Subscription;

use Neo\BrevoNewsletterBundle\Brevo\NameAttributes;

/**
 * The additional fields of the sign-up form (since 1.1.0): Brevo's standard
 * attributes of a contact, each switched on in the module and, if wanted, required.
 *
 *  - firstname / lastname: the account's name attributes (FIRSTNAME, VORNAME, …;
 *    the module can choose another one, see NameAttributes);
 *  - sms: mobile number (Brevo attribute SMS), international format;
 *  - landline: landline number (LANDLINE_NUMBER), international format;
 *  - job_title: job title (JOB_TITLE).
 *
 * Own attributes of the account follow in a later version.
 */
final class ContactFields
{
    /**
     * Key => what the form and Brevo need. Order = order in the form: the names
     * stand before the e-mail address, the others after it.
     */
    public const FIELDS = [
        'firstname' => ['attribute' => '', 'type' => 'text', 'autocomplete' => 'given-name', 'before' => true],
        'lastname' => ['attribute' => '', 'type' => 'text', 'autocomplete' => 'family-name', 'before' => true],
        'sms' => ['attribute' => 'SMS', 'type' => 'tel', 'autocomplete' => 'tel', 'before' => false],
        'landline' => ['attribute' => 'LANDLINE_NUMBER', 'type' => 'tel', 'autocomplete' => 'tel', 'before' => false],
        'job_title' => ['attribute' => 'JOB_TITLE', 'type' => 'text', 'autocomplete' => 'organization-title', 'before' => false],
    ];

    public const MAX_LENGTH = 64;

    /**
     * The keys switched on in a module, in form order.
     *
     * @param array<mixed> $stored deserialised brevo_fields
     *
     * @return list<string>
     */
    public static function enabled(array $stored): array
    {
        return array_values(array_intersect(array_keys(self::FIELDS), array_map('strval', $stored)));
    }

    /** A value as typed: one line, no tags, at most MAX_LENGTH characters. */
    public static function clean(mixed $value): string
    {
        $value = \is_scalar($value) ? (string) $value : '';

        return mb_substr(trim((string) preg_replace('/\s+/u', ' ', strip_tags($value))), 0, self::MAX_LENGTH);
    }

    public static function isPhone(string $key): bool
    {
        return 'tel' === (self::FIELDS[$key]['type'] ?? '');
    }

    /**
     * A phone number in the international format Brevo requires (+ and 7 to 15
     * digits); spaces, dots, dashes, slashes and brackets are dropped, a leading 00
     * becomes +.
     *
     * @return string the number, '' if it is not in international format
     */
    public static function phone(string $value): string
    {
        $number = (string) preg_replace('/[\s.\-\/()]+/', '', $value);

        if (str_starts_with($number, '00')) {
            $number = '+'.substr($number, 2);
        }

        return 1 === preg_match('/^\+[1-9]\d{6,14}$/', $number) ? $number : '';
    }

    /**
     * The Brevo attributes for the values given.
     *
     * @param array<string, string> $values    key => cleaned value
     * @param array<string, string> $available attributes of the account (only needed for automatic names)
     *
     * @return array<string, string>
     */
    public static function attributes(array $values, string $firstAttribute, string $lastAttribute, array $available): array
    {
        $attributes = [];

        foreach ($values as $key => $value) {
            if ('' === $value || !isset(self::FIELDS[$key])) {
                continue;
            }

            $attribute = match ($key) {
                'firstname' => NameAttributes::resolve($firstAttribute, $available, NameAttributes::FIRST),
                'lastname' => NameAttributes::resolve($lastAttribute, $available, NameAttributes::LAST),
                default => self::FIELDS[$key]['attribute'],
            };

            if ('' !== $attribute) {
                $attributes[$attribute] = $value;
            }
        }

        return $attributes;
    }
}
