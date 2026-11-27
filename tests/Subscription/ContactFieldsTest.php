<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Subscription;

use Neo\BrevoNewsletterBundle\Subscription\ContactFields;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class ContactFieldsTest extends TestCase
{
    public function testOnlyKnownFieldsInFormOrder(): void
    {
        $this->assertSame(['firstname', 'sms'], ContactFields::enabled(['sms', 'unknown', 'firstname']));
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function phoneNumbers(): iterable
    {
        yield 'with spaces' => ['+43 660 1234567', '+436601234567'];
        yield '00 instead of +' => ['0049 (30) 123-456/78', '+493012345678'];
        yield 'without country code' => ['0660 1234567', ''];
        yield 'too short' => ['+43 12', ''];
        yield 'letters' => ['+43 660 CALLME', ''];
    }

    #[DataProvider('phoneNumbers')]
    public function testPhoneNumbersInInternationalFormat(string $typed, string $expected): void
    {
        $this->assertSame($expected, ContactFields::phone($typed));
    }

    public function testValuesAreOneLineWithoutTags(): void
    {
        $this->assertSame('Max Mustermann', ContactFields::clean("  <i>Max</i>\n  Mustermann "));
        $this->assertSame(ContactFields::MAX_LENGTH, mb_strlen(ContactFields::clean(str_repeat('ä', 100))));
        $this->assertSame('', ContactFields::clean(['array']));
    }

    public function testTheNamesGoToTheDefaultAttributesOfTheAccount(): void
    {
        $values = ['firstname' => 'Max', 'lastname' => 'Mustermann', 'sms' => '+436601234567', 'job_title' => 'Chef'];

        $this->assertSame(
            ['VORNAME' => 'Max', 'NACHNAME' => 'Mustermann', 'SMS' => '+436601234567', 'JOB_TITLE' => 'Chef'],
            ContactFields::attributes($values, '', '', ['NACHNAME' => 'NACHNAME', 'SMS' => 'SMS', 'VORNAME' => 'VORNAME']),
        );
        $this->assertSame(['FIRSTNAME' => 'Max'], ContactFields::attributes(['firstname' => 'Max'], '', '', ['FIRSTNAME' => 'FIRSTNAME', 'VORNAME' => 'VORNAME']));
        $this->assertSame(['FIRSTNAME' => 'Max'], ContactFields::attributes(['firstname' => 'Max'], '', '', []), 'no answer from Brevo');
        $this->assertSame(['GIVEN' => 'Max'], ContactFields::attributes(['firstname' => 'Max'], 'given', '', ['VORNAME' => 'VORNAME']), 'chosen in the module');
        $this->assertSame([], ContactFields::attributes(['firstname' => 'Max'], '', '', ['SMS' => 'SMS']), 'account without a name attribute');
    }
}
