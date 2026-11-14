<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\EventListener;

use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\Form;
use Contao\FormFieldModel;
use Contao\PageModel;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Neo\BrevoNewsletterBundle\Brevo\BrevoClient;
use Neo\BrevoNewsletterBundle\EventListener\BrevoOptinFormListener;
use Neo\BrevoNewsletterBundle\Tests\Support\Database;
use Neo\BrevoNewsletterBundle\Tests\Support\FakeModels;
use Neo\BrevoNewsletterBundle\Tests\Support\MemoryLogger;
use Neo\BrevoNewsletterBundle\Tests\Support\Models;
use Neo\BrevoNewsletterBundle\Tests\Support\RecordingClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * The "Brevo sign-up" field of the form generator.
 */
final class BrevoOptinFormListenerTest extends TestCase
{
    use Models;

    private MemoryLogger $systemLog;

    private MemoryLogger $appLog;

    protected function setUp(): void
    {
        $this->systemLog = new MemoryLogger();
        $this->appLog = new MemoryLogger();
        FakeModels::$formFieldQueries = [];
    }

    public function testATickedOptInSubscribesWithTheNames(): void
    {
        $http = new RecordingClient(new MockResponse('', ['http_code' => 201]));

        $this->submit($http, ['newsletter' => '1', 'mail' => 'max@example.com', 'first' => ' Max ', 'last' => 'Mustermann']);

        $this->assertSame(['email' => 'max@example.com', 'includeListIds' => [7], 'templateId' => 4, 'redirectionUrl' => 'https://example.com/confirmed', 'attributes' => ['VORNAME' => 'Max', 'NACHNAME' => 'Mustermann']], $http->requests[0]['body']);
        $this->assertSame([], $this->systemLog->records);
        $this->assertSame([42], FakeModels::$formFieldQueries[0][1], 'the fields of this form');
    }

    public function testWhenBrevoRefusesTheNamesTheSignUpIsSentWithoutThem(): void
    {
        $http = new RecordingClient(RecordingClient::json(['message' => 'Attribute VORNAME does not exist'], 400), new MockResponse('', ['http_code' => 201]));

        $this->submit($http, ['newsletter' => '1', 'mail' => 'max@example.com', 'first' => 'Max']);

        $this->assertCount(2, $http->requests);
        $this->assertArrayNotHasKey('attributes', $http->requests[1]['body']);
        $this->assertSame([], $this->systemLog->records);
    }

    public function testAnOptInNotTickedOrWithoutValidAddressSendsNothing(): void
    {
        $http = new RecordingClient();

        $this->submit($http, ['newsletter' => '', 'mail' => 'max@example.com']);
        $this->submit($http, ['mail' => 'max@example.com']);
        $this->submit($http, ['newsletter' => '1', 'mail' => 'not an address']);

        $this->assertSame([], $http->requests);
    }

    public function testAnIncompleteFieldIsReportedAndTheFormGoesOn(): void
    {
        $http = new RecordingClient();

        $this->submit($http, ['newsletter' => '1', 'mail' => 'max@example.com'], '', ['brevo_lists' => serialize([]), 'brevo_doi_template' => 0]);

        $this->assertSame([], $http->requests);
        $this->assertSame(['error: Brevo newsletter: the sign-up through the form field "newsletter" (ID 3, form ID 42) failed, the visitor was not subscribed; the form was processed as usual: the field is not complete (missing: API key, list, DOI template).'], $this->systemLog->records);
    }

    public function testErrorsNeverStopTheFormAndLeaveTheAddressOut(): void
    {
        $this->submit(new RecordingClient(RecordingClient::unreachable()), ['newsletter' => '1', 'mail' => 'max.mustermann@example.com']);

        $this->assertStringContainsString('Could not resolve host', implode("\n", $this->systemLog->records));
        $this->assertStringNotContainsString('max.mustermann', implode("\n", [...$this->systemLog->records, ...$this->appLog->records]));
    }

    public function testARefusalWithoutNamesIsReported(): void
    {
        $this->submit(new RecordingClient(RecordingClient::json(['message' => 'Invalid template'], 400)), ['newsletter' => '1', 'mail' => 'max@example.com']);

        $this->assertStringContainsString('Brevo refused it (HTTP 400: Invalid template)', implode("\n", $this->systemLog->records));
    }

    /**
     * @param array<string, mixed> $submitted
     * @param array<string, mixed> $field
     */
    private function submit(RecordingClient $http, array $submitted, string $apiKey = 'xkeysib-test', array $field = []): void
    {
        $formField = $this->model(FormFieldModel::class, $field + [
            'id' => 3,
            'pid' => 42,
            'name' => 'newsletter',
            'brevo_email_field' => 'mail',
            'brevo_firstname_field' => 'first',
            'brevo_lastname_field' => 'last',
            'brevo_lists' => serialize(['7']),
            'brevo_doi_template' => 4,
            'brevo_redirect' => 12,
        ]);

        $urls = $this->createStub(ContentUrlGenerator::class);
        $urls->method('generate')->willReturn('https://example.com/confirmed');

        $listener = new BrevoOptinFormListener(
            new BrevoClient($http->client, new ArrayAdapter(), $this->appLog),
            new ApiKeyResolver(Database::settings(Database::connection(), $apiKey)),
            $urls,
            $this->framework([], [12 => $this->model(PageModel::class, ['id' => 12])], [$formField]),
            $this->appLog,
            $this->systemLog,
        );

        $form = $this->createStub(Form::class);
        $form->method('__get')->willReturnCallback(static fn (string $key): mixed => 'id' === $key ? 42 : null);

        $listener($submitted, [], [], [], $form);
    }
}
