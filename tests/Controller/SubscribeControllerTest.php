<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Controller;

use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\ModuleModel;
use Contao\PageModel;
use Neo\BrevoNewsletterBundle\Brevo\ApiKeyResolver;
use Neo\BrevoNewsletterBundle\Brevo\BrevoClient;
use Neo\BrevoNewsletterBundle\Controller\SubscribeController;
use Neo\BrevoNewsletterBundle\Subscription\ProofOfWork;
use Neo\BrevoNewsletterBundle\Subscription\SignupGuard;
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

    /** Shared by the spam protection of all controllers of one test (like the app cache). */
    private ArrayAdapter $cache;

    private ProofOfWork $proofOfWork;

    protected function setUp(): void
    {
        $this->systemLog = new MemoryLogger();
        $this->appLog = new MemoryLogger();
        $this->cache = new ArrayAdapter();
        // A small range keeps solving the task in the tests quick.
        $this->proofOfWork = new ProofOfWork($this->cache, 'test-secret', 50);
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

    public function testTheSixthAttemptOfAClientWithinTenMinutesIsRefused(): void
    {
        $http = new RecordingClient();
        $controller = $this->controller($http);

        for ($i = 0; $i < 5; ++$i) {
            $this->assertSame(400, $controller->subscribe($this->request(['email' => 'max@', 'consent' => '1', 'mod' => 5]))->getStatusCode());
        }

        $this->assertSame(['status' => 'rate_limited', 'ok' => false], $this->json($controller->subscribe($this->request(['email' => self::EMAIL, 'consent' => '1', 'mod' => 5])), 429));
        $this->assertSame([], $http->requests);
    }

    public function testWithoutASolvedTaskNothingReachesBrevo(): void
    {
        $http = new RecordingClient();

        foreach (['', 'not-base64', base64_encode('{"algorithm":"SHA-256"}')] as $altcha) {
            $response = $this->subscribe($http, ['email' => self::EMAIL, 'consent' => '1', 'mod' => 5, 'altcha' => $altcha]);
            $this->assertSame(['status' => 'verify', 'ok' => false], $this->json($response, 400));
        }

        $this->assertSame([], $http->requests);
    }

    public function testASolvedTaskCountsOnce(): void
    {
        $http = new RecordingClient(new MockResponse('', ['http_code' => 201]));
        $altcha = $this->solved();

        $this->assertSame(200, $this->subscribe($http, ['email' => self::EMAIL, 'consent' => '1', 'mod' => 5, 'altcha' => $altcha])->getStatusCode());

        $again = $this->controller($http)->subscribe($this->request(['email' => 'erika@example.com', 'consent' => '1', 'mod' => 5, 'altcha' => $altcha], true, '', '192.0.2.9'));
        $this->assertSame(['status' => 'verify', 'ok' => false], $this->json($again, 400));
        $this->assertCount(1, $http->requests);
    }

    public function testOneConfirmationEMailPerAddressIn24Hours(): void
    {
        $http = new RecordingClient(new MockResponse('', ['http_code' => 201]));

        $this->assertSame(200, $this->subscribe($http, ['email' => self::EMAIL, 'consent' => '1', 'mod' => 5])->getStatusCode());

        // Another visitor, the same address in other spelling: nothing is sent again.
        $again = $this->controller($http)->subscribe($this->request(['email' => strtoupper(self::EMAIL), 'consent' => '1', 'mod' => 5], true, '', '198.51.100.7'));
        $this->assertSame(['status' => 'repeat', 'ok' => false], $this->json($again, 409));
        $this->assertCount(1, $http->requests);
    }

    public function testAVisitorSignsUpAtMostTwoAddressesAnHour(): void
    {
        $http = new RecordingClient(new MockResponse('', ['http_code' => 201]), new MockResponse('', ['http_code' => 201]));
        $controller = $this->controller($http);

        foreach (['a@example.com', 'b@example.com'] as $email) {
            $this->assertSame(200, $controller->subscribe($this->request(['email' => $email, 'consent' => '1', 'mod' => 5]))->getStatusCode());
        }

        $third = $controller->subscribe($this->request(['email' => 'c@example.com', 'consent' => '1', 'mod' => 5]));
        $this->assertSame(['status' => 'rate_limited', 'ok' => false], $this->json($third, 429));
        $this->assertCount(2, $http->requests);
    }

    public function testTheModuleLimitStopsBotsThatChangeTheirAddressAndTellsTheOperatorOnce(): void
    {
        $http = new RecordingClient(new MockResponse('', ['http_code' => 201]), new MockResponse('', ['http_code' => 201]));
        $controller = $this->controller($http);

        // Module 10 allows two sign-ups an hour; every request comes from another IP address.
        foreach ([1, 2, 3, 4] as $i) {
            $responses[$i] = $controller->subscribe($this->request(['email' => "bot{$i}@example.com", 'consent' => '1', 'mod' => 10], true, '', '203.0.113.'.$i));
        }

        $this->assertSame(200, $responses[2]->getStatusCode());
        $this->assertSame(['status' => 'rate_limited', 'ok' => false], $this->json($responses[3], 429));
        $this->assertSame(429, $responses[4]->getStatusCode());
        $this->assertCount(2, $http->requests);
        $this->assertCount(1, $this->systemLog->records);
        $this->assertStringContainsString('the limit of 2 sign-ups an hour is reached', $this->systemLog->records[0]);
        $this->assertStringContainsString('"Limited" (ID 10)', $this->systemLog->records[0]);
    }

    /**
     * @return iterable<string, array{array<string, string>}>
     */
    public static function foreignRequests(): iterable
    {
        yield 'another website (Origin)' => [['HTTP_ORIGIN' => 'https://attacker.example.net']];
        yield 'another website (Sec-Fetch-Site)' => [['HTTP_SEC_FETCH_SITE' => 'cross-site']];
        yield 'no user agent' => [['HTTP_USER_AGENT' => '']];
        yield 'curl' => [['HTTP_USER_AGENT' => 'curl/8.5.0']];
        yield 'Python' => [['HTTP_USER_AGENT' => 'python-requests/2.32']];
        yield 'headless browser' => [['HTTP_USER_AGENT' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 HeadlessChrome/131.0 Safari/537.36']];
    }

    /**
     * @param array<string, string> $server
     */
    #[DataProvider('foreignRequests')]
    public function testRequestsFromOtherWebsitesAndScriptsAreRefused(array $server): void
    {
        $http = new RecordingClient();
        $request = $this->request(['email' => self::EMAIL, 'consent' => '1', 'mod' => 5]);
        $request->headers->add(array_combine(array_map(static fn (string $k): string => str_replace('_', '-', substr($k, 5)), array_keys($server)), $server));

        $this->assertSame(['status' => 'invalid', 'ok' => false], $this->json($this->controller($http)->subscribe($request), 400));
        $this->assertSame([], $http->requests);
    }

    public function testAdditionalFieldsGoToBrevoAsItsStandardAttributes(): void
    {
        $http = new RecordingClient(
            RecordingClient::json(['attributes' => [
                ['name' => 'VORNAME', 'category' => 'normal', 'type' => 'text'],
                ['name' => 'NACHNAME', 'category' => 'normal', 'type' => 'text'],
                ['name' => 'SMS', 'category' => 'normal', 'type' => 'text'],
            ]]),
            new MockResponse('', ['http_code' => 201]),
        );

        $response = $this->subscribe($http, ['email' => self::EMAIL, 'consent' => '1', 'mod' => 11, 'fields' => [
            'firstname' => ' Max ', 'lastname' => '<b>Mustermann</b>', 'sms' => '0043 660 123 45-67', 'landline' => '', 'job_title' => 'not switched on',
        ]]);

        $this->assertSame(['status' => 'ok', 'ok' => true], $this->json($response, 200));
        $this->assertSame('GET', $http->requests[0]['method']);
        $this->assertSame(['VORNAME' => 'Max', 'NACHNAME' => 'Mustermann', 'SMS' => '+436601234567'], $http->requests[1]['body']['attributes']);
    }

    public function testARequiredFieldMustBeFilled(): void
    {
        $http = new RecordingClient();

        $response = $this->subscribe($http, ['email' => self::EMAIL, 'consent' => '1', 'mod' => 11, 'fields' => ['lastname' => 'Mustermann']]);

        $this->assertSame(['status' => 'fields', 'ok' => false], $this->json($response, 400));
        $this->assertSame([], $http->requests);
    }

    public function testAPhoneNumberMustBeInternational(): void
    {
        $http = new RecordingClient();

        $response = $this->subscribe($http, ['email' => self::EMAIL, 'consent' => '1', 'mod' => 11, 'fields' => ['firstname' => 'Max', 'sms' => '0660 1234567']]);

        $this->assertSame(['status' => 'phone', 'ok' => false], $this->json($response, 400));
        $this->assertSame([], $http->requests);
    }

    public function testIfBrevoRefusesTheAttributesTheVisitorIsSignedUpWithoutThem(): void
    {
        $http = new RecordingClient(
            RecordingClient::json(['code' => 'duplicate_parameter', 'message' => 'SMS is already associated with another Contact'], 400),
            new MockResponse('', ['http_code' => 201]),
        );

        $response = $this->subscribe($http, ['email' => self::EMAIL, 'consent' => '1', 'mod' => 12, 'fields' => ['firstname' => 'Max', 'sms' => '+436601234567']]);

        $this->assertSame(['status' => 'ok', 'ok' => true], $this->json($response, 200));
        $this->assertSame(['FIRST' => 'Max', 'SMS' => '+436601234567'], $http->requests[0]['body']['attributes']);
        $this->assertArrayNotHasKey('attributes', $http->requests[1]['body']);
        $this->assertStringContainsString('Brevo refused the attributes FIRST, SMS', implode("\n", $this->systemLog->records));
    }

    public function testAJsonBodyIsRead(): void
    {
        $http = new RecordingClient(new MockResponse('', ['http_code' => 201]));
        $request = Request::create('https://example.com/api/brevo/subscribe', 'POST', [], [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json', 'REMOTE_ADDR' => '192.0.2.1'], (string) json_encode(['email' => self::EMAIL, 'consent' => true, 'mod' => 6, 'lists' => [7], 'altcha' => $this->solved()]));

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
        $module = static fn (int $id, string $name, string $mode, array $lists, int $template, int $redirect, string $type = 'brevo_newsletter', array $more = []): array => [
            'id' => $id, 'name' => $name, 'type' => $type, 'brevo_mode' => $mode, 'brevo_lists' => serialize($lists), 'brevo_doi_template' => $template, 'brevo_redirect' => $redirect,
        ] + $more;

        $framework = $this->framework(
            [
                5 => $this->model(ModuleModel::class, $module(5, 'Sign-up', 'fixed', ['7', '3'], 4, 12)),
                6 => $this->model(ModuleModel::class, $module(6, 'Choice', 'choice', ['7', '3'], 4, 12)),
                8 => $this->model(ModuleModel::class, $module(8, 'Navigation', 'fixed', ['7'], 4, 12, 'navigation')),
                9 => $this->model(ModuleModel::class, $module(9, 'Incomplete', 'fixed', ['7'], 0, 0)),
                10 => $this->model(ModuleModel::class, $module(10, 'Limited', 'fixed', ['7'], 4, 12, more: ['brevo_limit_hour' => 2, 'brevo_limit_day' => 0])),
                11 => $this->model(ModuleModel::class, $module(11, 'Fields', 'fixed', ['7'], 4, 12, more: ['brevo_fields' => serialize(['firstname', 'lastname', 'sms', 'landline']), 'brevo_fields_required' => serialize(['firstname'])])),
                12 => $this->model(ModuleModel::class, $module(12, 'Own attribute', 'fixed', ['7'], 4, 12, more: ['brevo_fields' => serialize(['firstname', 'sms']), 'brevo_attr_firstname' => 'first'])),
            ],
            [12 => $this->model(PageModel::class, ['id' => 12])],
        );

        $urls = $this->createStub(ContentUrlGenerator::class);
        $urls->method('generate')->willReturn('https://example.com/confirmed');

        return new SubscribeController(
            $framework,
            new BrevoClient($http->client, new ArrayAdapter(), $this->appLog),
            new ApiKeyResolver(Database::settings(Database::connection(), $apiKey)),
            new SubscribeRateLimiter($this->cache),
            $urls,
            $this->proofOfWork,
            new SignupGuard($this->cache, 'test-secret'),
            $this->appLog,
            $this->systemLog,
        );
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function request(array $payload, bool $json = true, string $referer = '', string $ip = '192.0.2.1'): Request
    {
        $server = ['REMOTE_ADDR' => $ip, 'HTTP_USER_AGENT' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0 Safari/537.36'];
        // Every sign-up carries a solved task, as the browser sends it, unless the test sets its own.
        $payload += ['altcha' => $this->solved()];

        if ($json) {
            $server['HTTP_ACCEPT'] = 'application/json';
        }

        if ('' !== $referer) {
            $server['HTTP_REFERER'] = $referer;
        }

        return Request::create('https://example.com/api/brevo/subscribe', 'POST', $payload, [], [], $server);
    }

    /** A task handed out ten seconds ago, solved like the browser does. */
    private function solved(): string
    {
        $task = $this->proofOfWork->challenge(time() - 10);

        for ($n = 0; $n <= $task['maxnumber']; ++$n) {
            if (hash('sha256', $task['salt'].$n) === $task['challenge']) {
                return base64_encode((string) json_encode(['algorithm' => $task['algorithm'], 'challenge' => $task['challenge'], 'number' => $n, 'salt' => $task['salt'], 'signature' => $task['signature']]));
            }
        }

        throw new \LogicException('Unsolvable task');
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
