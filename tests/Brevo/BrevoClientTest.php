<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Brevo;

use Neo\BrevoNewsletterBundle\Brevo\BrevoClient;
use Neo\BrevoNewsletterBundle\Tests\Support\MemoryLogger;
use Neo\BrevoNewsletterBundle\Tests\Support\RecordingClient;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpClient\Exception\TransportException;
use Symfony\Component\HttpClient\Response\MockResponse;

final class BrevoClientTest extends TestCase
{
    private ArrayAdapter $cache;

    private MemoryLogger $logger;

    protected function setUp(): void
    {
        $this->cache = new ArrayAdapter();
        $this->logger = new MemoryLogger();
    }

    public function testListsOfTheAccountByIdCached(): void
    {
        $http = new RecordingClient(RecordingClient::json(['lists' => [['id' => 7, 'name' => 'Newsletter'], ['id' => '3', 'name' => 'Events'], ['name' => 'no id']], 'count' => 3]));
        $brevo = $this->client($http);

        $this->assertSame([7 => 'Newsletter', 3 => 'Events'], $brevo->getLists('xkeysib-test'));
        $this->assertSame([7 => 'Newsletter', 3 => 'Events'], $brevo->getLists('xkeysib-test'));
        $this->assertCount(1, $http->requests);
        $this->assertStringStartsWith('https://api.brevo.com/v3/contacts/lists?', $http->requests[0]['url']);
        $this->assertSame('xkeysib-test', $http->requests[0]['headers']['api-key']);
    }

    public function testListsArePerKey(): void
    {
        $http = new RecordingClient(RecordingClient::json(['lists' => [['id' => 1, 'name' => 'A']]]), RecordingClient::json(['lists' => [['id' => 2, 'name' => 'B']]]));
        $brevo = $this->client($http);

        $this->assertSame([1 => 'A'], $brevo->getLists('key-one'));
        $this->assertSame([2 => 'B'], $brevo->getLists('key-two'));
    }

    public function testWithoutKeyOrAnswerThereAreNoLists(): void
    {
        $http = new RecordingClient(RecordingClient::unreachable(), RecordingClient::json(['message' => 'Key not found'], 401));
        $brevo = $this->client($http);

        $this->assertSame([], $brevo->getLists(''));
        $this->assertSame([], $http->requests);
        $this->assertSame([], $brevo->getLists('key-one'));
        $this->assertSame([], $brevo->getLists('key-two'));
    }

    public function testTemplatesAreLabelledWithIdAndInactiveOnes(): void
    {
        $http = new RecordingClient(RecordingClient::json(['templates' => [
            ['id' => 4, 'name' => 'Double opt-in', 'isActive' => true],
            ['id' => 9, 'name' => 'Old', 'isActive' => false],
            ['id' => 11],
        ]]));

        $this->assertSame([4 => 'Double opt-in (#4)', 9 => 'Old (#9) – inactive'], $this->client($http)->getTemplates('xkeysib-test'));
        $this->assertStringStartsWith('https://api.brevo.com/v3/smtp/templates?', $http->requests[0]['url']);
    }

    public function testTheDoubleOptInRequest(): void
    {
        $http = new RecordingClient(new MockResponse('', ['http_code' => 201]));
        $brevo = $this->client($http);

        $this->assertTrue($brevo->createDoiContact('xkeysib-test', 'max@example.com', ['7', 3], 4, 'https://example.com/confirmed', ['VORNAME' => 'Max']));
        $this->assertSame('', $brevo->lastError());

        $request = $http->requests[0];
        $this->assertSame('POST', $request['method']);
        $this->assertSame('https://api.brevo.com/v3/contacts/doubleOptinConfirmation', $request['url']);
        $this->assertSame('xkeysib-test', $request['headers']['api-key']);
        $this->assertSame(['email' => 'max@example.com', 'includeListIds' => [7, 3], 'templateId' => 4, 'redirectionUrl' => 'https://example.com/confirmed', 'attributes' => ['VORNAME' => 'Max']], $request['body']);
    }

    public function testWithoutAttributesNoneAreSent(): void
    {
        $http = new RecordingClient(new MockResponse('', ['http_code' => 204]));

        $this->assertTrue($this->client($http)->createDoiContact('k', 'max@example.com', [7], 4, 'https://example.com/confirmed'));
        $this->assertArrayNotHasKey('attributes', $http->requests[0]['body']);
    }

    public function testARefusalIsExplainedAndLoggedWithoutTheAddress(): void
    {
        $http = new RecordingClient(RecordingClient::json(['code' => 'invalid_parameter', 'message' => 'Template is not a double opt-in template'], 400));
        $brevo = $this->client($http);

        $this->assertFalse($brevo->createDoiContact('xkeysib-test', 'max.mustermann@example.com', [7], 4, 'https://example.com/confirmed'));
        $this->assertSame('HTTP 400: Template is not a double opt-in template', $brevo->lastError());

        $log = implode("\n", $this->logger->records);
        $this->assertStringContainsString('error: Brevo rejected the sign-up (HTTP 400): Template is not a double opt-in template [code=invalid_parameter, templateId=4, listIds=7', $log);
        $this->assertStringNotContainsString('max.mustermann', $log);
        $this->assertStringNotContainsString('xkeysib-test', $log);
    }

    public function testTheLastErrorIsClearedByTheNextCall(): void
    {
        $http = new RecordingClient(RecordingClient::json(['message' => 'Bad'], 400), new MockResponse('', ['http_code' => 201]));
        $brevo = $this->client($http);

        $brevo->createDoiContact('k', 'max@example.com', [7], 4, 'https://example.com/confirmed');
        $brevo->createDoiContact('k', 'max@example.com', [7], 4, 'https://example.com/confirmed');

        $this->assertSame('', $brevo->lastError());
    }

    public function testAMissingConnectionIsLeftToTheCaller(): void
    {
        $this->expectException(TransportException::class);

        $this->client(new RecordingClient(RecordingClient::unreachable()))->createDoiContact('k', 'max@example.com', [7], 4, 'https://example.com/confirmed');
    }

    private function client(RecordingClient $http): BrevoClient
    {
        return new BrevoClient($http->client, $this->cache, $this->logger);
    }
}
