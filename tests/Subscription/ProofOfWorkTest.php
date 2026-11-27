<?php

declare(strict_types=1);

namespace Neo\BrevoNewsletterBundle\Tests\Subscription;

use Neo\BrevoNewsletterBundle\Subscription\ProofOfWork;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

/**
 * The invisible task of the spam protection: only a real, fresh, unused solution
 * of a task handed out by this installation counts.
 */
final class ProofOfWorkTest extends TestCase
{
    private const NOW = 1_800_000_000;

    public function testATaskHasTheFormatOfAltcha(): void
    {
        $task = (new ProofOfWork(new ArrayAdapter(), 'secret', 50))->challenge(self::NOW);

        $this->assertSame('SHA-256', $task['algorithm']);
        $this->assertSame(50, $task['maxnumber']);
        $this->assertMatchesRegularExpression('/^[0-9a-f]{64}$/', $task['challenge']);
        $this->assertStringContainsString('?expires='.(self::NOW + ProofOfWork::LIFETIME).'&issued='.self::NOW.'&', $task['salt']);
    }

    public function testASolutionIsAcceptedOnce(): void
    {
        $pow = new ProofOfWork(new ArrayAdapter(), 'secret', 50);
        $payload = $this->solve($pow->challenge(self::NOW));

        $this->assertSame('', $pow->verify($payload, self::NOW + 5));
        $this->assertSame('replay', $pow->verify($payload, self::NOW + 6));
    }

    public function testASolutionIsOnlyAcceptedAfterAFewSecondsAndBeforeItExpires(): void
    {
        $pow = new ProofOfWork(new ArrayAdapter(), 'secret', 50);
        $task = $pow->challenge(self::NOW);

        $this->assertSame('early', $pow->verify($this->solve($task), self::NOW + 1));
        $this->assertSame('expired', $pow->verify($this->solve($task), self::NOW + ProofOfWork::LIFETIME + 1));
    }

    public function testAWrongNumberOrAChangedTaskIsRefused(): void
    {
        $pow = new ProofOfWork(new ArrayAdapter(), 'secret', 50);
        $task = $pow->challenge(self::NOW);
        $data = json_decode(base64_decode($this->solve($task)), true);

        $wrong = $data;
        $wrong['number'] = ($data['number'] + 1) % 51;
        $this->assertSame('wrong', $pow->verify(base64_encode(json_encode($wrong)), self::NOW + 5));

        // Extending the expiry changes the salt, so the challenge no longer matches.
        $longer = $data;
        $longer['salt'] = str_replace('expires=', 'expires=9', $data['salt']);
        $this->assertSame('wrong', $pow->verify(base64_encode(json_encode($longer)), self::NOW + 5));

        // A task of another installation (other secret) is not valid here.
        $foreign = new ProofOfWork(new ArrayAdapter(), 'other-secret', 50);
        $this->assertSame('wrong', $foreign->verify($this->solve($task), self::NOW + 5));
    }

    public function testBrokenPayloadsAreRefused(): void
    {
        $pow = new ProofOfWork(new ArrayAdapter(), 'secret', 50);

        $this->assertSame('missing', $pow->verify(' ', self::NOW));
        $this->assertSame('malformed', $pow->verify('%%%', self::NOW));
        $this->assertSame('malformed', $pow->verify(base64_encode('{"algorithm":"SHA-256"}'), self::NOW));
        $this->assertSame('malformed', $pow->verify(base64_encode('{"algorithm":"SHA-1","challenge":"a","number":1,"salt":"b","signature":"c"}'), self::NOW));
        $this->assertSame('malformed', $pow->verify(base64_encode('{"algorithm":"SHA-256","challenge":"a","number":51,"salt":"b","signature":"c"}'), self::NOW));
    }

    /**
     * @param array{algorithm: string, challenge: string, salt: string, signature: string, maxnumber: int} $task
     */
    private function solve(array $task): string
    {
        for ($n = 0; $n <= $task['maxnumber']; ++$n) {
            if (hash('sha256', $task['salt'].$n) === $task['challenge']) {
                return base64_encode((string) json_encode(['algorithm' => $task['algorithm'], 'challenge' => $task['challenge'], 'number' => $n, 'salt' => $task['salt'], 'signature' => $task['signature']]));
            }
        }

        throw new \LogicException('Unsolvable task');
    }
}
