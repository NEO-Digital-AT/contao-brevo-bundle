<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Controller;

use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\ModuleModel;
use Contao\PageModel;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Neo\BrevoNewsletterBundle\Brevo\BrevoClient;
use Neo\BrevoNewsletterBundle\Controller\SubscribeController;
use Neo\BrevoNewsletterBundle\Subscription\SubscribeRateLimiter;
use Neo\BrevoNewsletterBundle\Tests\Support\Database;
use Neo\BrevoNewsletterBundle\Tests\Support\MemoryLogger;
use Neo\BrevoNewsletterBundle\Tests\Support\Models;
use Neo\BrevoNewsletterBundle\Tests\Support\RecordingClient;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * POST /api/brevo/subscribe: what reaches Brevo, and what the visitor and the
 * operator are told.
 */
final class SubscribeControllerTest extends TestCase
{
    use Models;

    private const EMAIL = 'max.mustermann@example.com';

    private MemoryLogger $systemLog;

    private MemoryLogger $appLog;

    protected function setUp(): void
    {
        $this->systemLog = new MemoryLogger();
        $this->appLog = new MemoryLogger();
    }

    public function testAFixedModuleSubscribesToItsConfiguredListsWhateverTheClientSends(): void
    {
        $http = new RecordingClient(new MockResponse('', ['http_code' => 201]));

        $response = $this->subscribe($http, ['email' => ' '.self::EMAIL.' ', 'consent' => '1', 'mod' => '5', 'lists' => ['99']]);

        $this->assertSame(['status' => 'ok', 'ok' => true], $this->json($response, 200));
        $this->assertSame([7, 3], $http->requests[0]['body']['includeListIds']);
        $this->assertSame(self::EMAIL, $http->requests[0]['body']['email']);
        $this->assertSame(4, $http->requests[0]['body']['templateId']);
        $this->assertSame('https://example.com/confirmed', $http->requests[0]['body']['redirectionUrl']);
        $this->assertSame('xkeysib-test', $http->requests[0]['headers']['api-key']);
    }

    public function testInChoiceModeOnlyConfiguredListsOfTheChoiceAreUsed(): void
    {
        $http = new RecordingClient(new MockResponse('', ['http_code' => 201]));

        $this->subscribe($http, ['email' => self::EMAIL, 'consent' => 'on', 'mod' => 6, 'lists' => ['3', '99', 'x']]);

        $this->assertSame([3], $http->requests[0]['body']['includeListIds']);
    }

    public function testInChoiceModeAChoiceOutsideTheConfiguredListsIsRefused(): void
    {
        $http = new RecordingClient();

        $response = $this->subscribe($http, ['email' => self::EMAIL, 'consent' => true, 'mod' => 6, 'lists' => '99']);

        $this->assertSame(['status' => 'choose', 'ok' => false], $this->json($response, 400));
        $this->assertSame([], $http->requests);
    }

    /**
     * @return iterable<string, array{array<string, mixed>}>
     */
    public static function invalidSignUps(): iterable
    {
        yield 'honeypot filled' => [['email' => self::EMAIL, 'consent' => '1', 'mod' => 5, 'website' => 'https://spam.example.com']];
        yield 'no consent' => [['email' => self::EMAIL, 'mod' => 5]];
        yield 'consent not ticked' => [['email' => self::EMAIL, 'consent' => '0', 'mod' => 5]];
        yield 'invalid address' => [['email' => 'max@', 'consent' => '1', 'mod' => 5]];
        yield 'unknown module' => [['email' => self::EMAIL, 'consent' => '1', 'mod' => 404]];
        yield 'module of another type' => [['email' => self::EMAIL, 'consent' => '1', 'mod' => 8]];
    }

    #[DataProvider('invalidSignUps')]
    public function testInvalidSignUpsDoNotReachBrevo(array $payload): void
    {
        $http = new RecordingClient();

        $this->assertSame(['status' => 'invalid', 'ok' => false], $this->json($this->subscribe($http, $payload), 400));
        $this->assertSame([], $http->requests);
    }

    public function testAnIncompleteModuleIsReportedToTheOperatorWithWhatIsMissing(): void
    {
        $http = new RecordingClient();

        $response = $this->subscribe($http, ['email' => self::EMAIL, 'consent' => '1', 'mod' => 9], '');

        $this->assertSame(['status' => 'not_configured', 'ok' => false], $this->json($response, 503));
        $this->assertSame([], $http->requests);
        $this->assertSame(['error: Brevo newsletter: a sign-up in the module "Incomplete" (ID 9) failed, the visitor was not subscribed: the module is not complete (missing: API key, DOI template, confirmation page).'], $this->systemLog->records);
    }

    public function testARefusalOfBrevoIsReportedWithoutTheAddress(): void
    {
        $http = new RecordingClient(RecordingClient::json(['code' => 'invalid_parameter', 'message' => 'Sender not verified'], 400));

        $response = $this->subscribe($http, ['email' => self::EMAIL, 'consent' => '1', 'mod' => 5]);

        $this->assertSame(['status' => 'send_failed', 'ok' => false], $this->json($response, 502));
        $this->assertSame(['error: Brevo newsletter: a sign-up in the module "Sign-up" (ID 5) failed, the visitor was not subscribed: Brevo refused it (HTTP 400: Sender not verified).'], $this->systemLog->records);
        $this->assertStringNotContainsString(self::EMAIL, implode("\n", [...$this->systemLog->records, ...$this->appLog->records]));
    }

    public function testNoConnectionToBrevoIsReported(): void
    {
        $response = $this->subscribe(new RecordingClient(RecordingClient::unreachable()), ['email' => self::EMAIL, 'consent' => '1', 'mod' => 5]);

        $this->assertSame(['status' => 'send_failed', 'ok' => false], $this->json($response, 502));
        $this->assertStringContainsString('Could not resolve host', implode("\n", $this->systemLog->records));
        $this->assertStringContainsString('error: Brevo sign-up failed:', implode("\n", $this->appLog->records));
    }

    public function testTheNinthSignUpOfAClientWithinAMinuteIsRefused(): void
    {
        $http = new RecordingClient(...array_fill(0, 8, new MockResponse('', ['http_code' => 201])));
        $controller = $this->controller($http);

        for ($i = 0; $i < 8; ++$i) {
            $this->assertSame(200, $controller->subscribe($this->request(['email' => self::EMAIL, 'consent' => '1', 'mod' => 5]))->getStatusCode());
        }

        $this->assertSame(['status' => 'rate_limited', 'ok' => false], $this->json($controller->subscribe($this->request(['email' => self::EMAIL, 'consent' => '1', 'mod' => 5])), 429));
        $this->assertCount(8, $http->requests);
    }

    public function testAJsonBodyIsRead(): void
    {
        $http = new RecordingClient(new MockResponse('', ['http_code' => 201]));
        $request = Request::create('https://example.com/api/brevo/subscribe', 'POST', [], [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json', 'REMOTE_ADDR' => '192.0.2.1'], (string) json_encode(['email' => self::EMAIL, 'consent' => true, 'mod' => 6, 'lists' => [7]]));

        $this->assertSame(200, $this->controller($http)->subscribe($request)->getStatusCode());
        $this->assertSame([7], $http->requests[0]['body']['includeListIds']);
    }

    public function testWithoutJavaScriptTheVisitorGoesBackToTheFormPageWithTheResult(): void
    {
        $http = new RecordingClient(new MockResponse('', ['http_code' => 201]));
        $request = $this->request(['email' => self::EMAIL, 'consent' => '1', 'mod' => 5], false, 'https://example.com/newsletter?ref=footer');

        $response = $this->controller($http)->subscribe($request);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertSame('https://example.com/newsletter?ref=footer&nl=ok', $response->getTargetUrl());
    }

    public function testTheBounceNeverLeadsToAnotherHost(): void
    {
        $request = $this->request(['email' => 'max@', 'consent' => '1', 'mod' => 5], false, 'https://attacker.example.net/phish');

        $response = $this->controller(new RecordingClient())->subscribe($request);

        $this->assertNotInstanceOf(RedirectResponse::class, $response);
        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame('Error', $response->getContent());
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function subscribe(RecordingClient $http, array $payload, string $apiKey = 'xkeysib-test'): Response
    {
        return $this->controller($http, $apiKey)->subscribe($this->request($payload));
    }

    private function controller(RecordingClient $http, string $apiKey = 'xkeysib-test'): SubscribeController
    {
        $module = static fn (int $id, string $name, string $mode, array $lists, int $template, int $redirect, string $type = 'brevo_newsletter'): array => [
            'id' => $id, 'name' => $name, 'type' => $type, 'brevo_mode' => $mode, 'brevo_lists' => serialize($lists), 'brevo_doi_template' => $template, 'brevo_redirect' => $redirect,
        ];

        $framework = $this->framework(
            [
                5 => $this->model(ModuleModel::class, $module(5, 'Sign-up', 'fixed', ['7', '3'], 4, 12)),
                6 => $this->model(ModuleModel::class, $module(6, 'Choice', 'choice', ['7', '3'], 4, 12)),
                8 => $this->model(ModuleModel::class, $module(8, 'Navigation', 'fixed', ['7'], 4, 12, 'navigation')),
                9 => $this->model(ModuleModel::class, $module(9, 'Incomplete', 'fixed', ['7'], 0, 0)),
            ],
            [12 => $this->model(PageModel::class, ['id' => 12])],
        );

        $urls = $this->createStub(ContentUrlGenerator::class);
        $urls->method('generate')->willReturn('https://example.com/confirmed');

        return new SubscribeController(
            $framework,
            new BrevoClient($http->client, new ArrayAdapter(), $this->appLog),
            new ApiKeyResolver(Database::settings(Database::connection(), $apiKey)),
            new SubscribeRateLimiter(new ArrayAdapter()),
            $urls,
            $this->appLog,
            $this->systemLog,
        );
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function request(array $payload, bool $json = true, string $referer = ''): Request
    {
        $server = ['REMOTE_ADDR' => '192.0.2.1'];

        if ($json) {
            $server['HTTP_ACCEPT'] = 'application/json';
        }

        if ('' !== $referer) {
            $server['HTTP_REFERER'] = $referer;
        }

        return Request::create('https://example.com/api/brevo/subscribe', 'POST', $payload, [], [], $server);
    }

    /**
     * @return array<string, mixed>
     */
    private function json(Response $response, int $status): array
    {
        $this->assertSame($status, $response->getStatusCode());

        return json_decode((string) $response->getContent(), true);
    }
}
