<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Support;

use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;

/**
 * A mock HTTP client that answers with the given responses in turn and keeps
 * every request (method, address, headers, decoded JSON body).
 */
final class RecordingClient
{
    /**
     * @var list<array{method: string, url: string, headers: array<string, string>, body: mixed}>
     */
    public array $requests = [];

    public readonly MockHttpClient $client;

    /**
     * @var list<MockResponse>
     */
    private array $responses;

    public function __construct(MockResponse ...$responses)
    {
        $this->responses = $responses;
        $this->client = new MockHttpClient(function (string $method, string $url, array $options): MockResponse {
            $headers = [];

            foreach ($options['normalized_headers'] ?? [] as $name => $lines) {
                $headers[$name] = substr((string) $lines[0], \strlen($name) + 2);
            }

            $this->requests[] = ['method' => $method, 'url' => $url, 'headers' => $headers, 'body' => json_decode((string) ($options['body'] ?? ''), true)];

            return array_shift($this->responses) ?? throw new \LogicException('Unexpected request to '.$url);
        });
    }

    /**
     * @param array<mixed> $data
     */
    public static function json(array $data, int $status = 200): MockResponse
    {
        return new MockResponse((string) json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), ['http_code' => $status, 'response_headers' => ['content-type' => 'application/json']]);
    }

    public static function unreachable(): MockResponse
    {
        return new MockResponse('', ['error' => 'Could not resolve host']);
    }
}
