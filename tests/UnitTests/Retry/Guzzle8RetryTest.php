<?php

namespace UnitTests\Retry;

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Fixtures' . DIRECTORY_SEPARATOR . 'RewindStatStream.php';

use AlibabaCloud\Oss\V2\ClientImpl;
use AlibabaCloud\Oss\V2\Config;
use AlibabaCloud\Oss\V2\Credentials;
use AlibabaCloud\Oss\V2\Exception;
use AlibabaCloud\Oss\V2\OperationInput;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Retry;
use AlibabaCloud\Oss\V2\Utils;
use GuzzleHttp;
use UnitTests\Fixtures\RewindStatStream;

/**
 * Simulates the transport failures raised by Guzzle 8.x handlers and checks that they go
 * through the sdk's retry middleware. Guzzle 8 only cases are skipped on older versions.
 */
class Guzzle8RetryTest extends \PHPUnit\Framework\TestCase
{
    private const MAX_ATTEMPTS = 3;

    // in second
    private const BACKOFF = 0.01;

    public function testGuzzle8ErrorRetryable()
    {
        self::requireGuzzle8();

        $r = new Retry\ClientErrorRetryable();
        foreach (self::guzzle8TransportErrors() as $name => $error) {
            $this->assertTrue($r->isErrorRetryable($error), $name . ' should be retryable');
        }

        // NetworkException is no longer a RequestException in Guzzle 8
        $error = self::guzzle8TransportErrors()['NetworkTimeoutException'];
        $this->assertNotInstanceOf(GuzzleHttp\Exception\RequestException::class, $error);
        $this->assertInstanceOf(\Psr\Http\Client\NetworkExceptionInterface::class, $error);

        $request = new GuzzleHttp\Psr7\Request('PUT', 'http://127.0.0.1/bucket/key');
        $this->assertFalse($r->isErrorRetryable(new GuzzleHttp\Exception\HandlerClosedException('handler closed', $request)));
        $this->assertFalse($r->isErrorRetryable(new GuzzleHttp\Exception\InvalidArgumentException('invalid option')));
    }

    public function testRetrySucceedsAfterGuzzle8TransportErrors()
    {
        self::requireGuzzle8();

        foreach (self::guzzle8TransportErrors() as $name => $error) {
            $calls = [];
            $mock = new GuzzleHttp\Handler\MockHandler([
                $error,
                $error,
                new GuzzleHttp\Psr7\Response(200, ['x-oss-request-id' => 'id-' . $name]),
            ]);
            $client = self::newClient(self::recordHandler($mock, $calls));

            $body = new RewindStatStream(Utils::streamFor('hello world'));
            $input = self::newInput();
            $input->setBody($body);

            $output = $client->executeAsync($input)->wait();
            $this->assertInstanceOf(OperationOutput::class, $output, $name);
            $this->assertEquals(200, $output->getStatusCode(), $name);
            $this->assertEquals('id-' . $name, $output->getHeaders()['x-oss-request-id'], $name);
            $this->assertEquals(0, $mock->count(), $name);
            $this->assertCount(self::MAX_ATTEMPTS, $calls, $name);
            // backoff delay is passed to the handler in milliseconds
            $this->assertEquals((int)(self::BACKOFF * 1000), $calls[1], $name);
            $this->assertEquals((int)(self::BACKOFF * 1000), $calls[2], $name);
            // the body is rewound before each retry
            $this->assertEquals(2, $body->getRewindCount(), $name);
        }
    }

    public function testRetryExhaustedOnGuzzle8TransportErrors()
    {
        self::requireGuzzle8();

        foreach (self::guzzle8TransportErrors() as $name => $error) {
            $calls = [];
            $mock = new GuzzleHttp\Handler\MockHandler(array_fill(0, self::MAX_ATTEMPTS + 1, $error));
            $client = self::newClient(self::recordHandler($mock, $calls));
            try {
                $operationInput = self::newInput();
                $client->executeAsync($operationInput)->wait();
                $this->fail('should not here, ' . $name);
            } catch (Exception\OperationException $e) {
                $this->assertInstanceOf(get_class($error), $e->getPrevious(), $name);
            }
            $this->assertCount(self::MAX_ATTEMPTS, $calls, $name);
            $this->assertEquals(1, $mock->count(), $name);
        }
    }

    public function testNoRetryOnGuzzle8NonRetryableErrors()
    {
        self::requireGuzzle8();

        $request = new GuzzleHttp\Psr7\Request('PUT', 'http://127.0.0.1/bucket/key');
        $errors = [
            'HandlerClosedException' => new GuzzleHttp\Exception\HandlerClosedException('handler closed', $request),
            'InvalidArgumentException' => new GuzzleHttp\Exception\InvalidArgumentException('invalid option'),
        ];
        foreach ($errors as $name => $error) {
            $calls = [];
            $mock = new GuzzleHttp\Handler\MockHandler(array_fill(0, self::MAX_ATTEMPTS, $error));
            $client = self::newClient(self::recordHandler($mock, $calls));
            try {
                $operationInput = self::newInput();
                $client->executeAsync($operationInput)->wait();
                $this->fail('should not here, ' . $name);
            } catch (Exception\OperationException $e) {
                $this->assertInstanceOf(get_class($error), $e->getPrevious(), $name);
            }
            $this->assertCount(1, $calls, $name);
        }
    }

    public function testRetryOnConnectionRefused()
    {
        // grab a free local port, then close it so that connecting to it is refused
        $server = stream_socket_server('tcp://127.0.0.1:0', $errno, $errstr);
        $this->assertNotFalse($server, $errstr);
        $address = stream_socket_get_name($server, false);
        fclose($server);

        $calls = [];
        $client = self::newClient(
            self::recordHandler(GuzzleHttp\Utils::chooseHandler(), $calls),
            'http://' . $address
        );
        try {
            $operationInput = self::newInput();
            $client->executeAsync($operationInput)->wait();
            $this->fail('should not here');
        } catch (Exception\OperationException $e) {
            $this->assertInstanceOf(GuzzleHttp\Exception\ConnectException::class, $e->getPrevious());
        }
        $this->assertCount(self::MAX_ATTEMPTS, $calls);
    }

    private static function requireGuzzle8(): void
    {
        if (!class_exists(GuzzleHttp\Exception\NetworkException::class)) {
            self::markTestSkipped('requires guzzlehttp/guzzle 8.x');
        }
    }

    /**
     * The transport errors which Guzzle 8.x handlers raise when a transfer fails.
     * @return array<string, \Throwable>
     */
    private static function guzzle8TransportErrors(): array
    {
        $request = new GuzzleHttp\Psr7\Request('PUT', 'http://127.0.0.1/bucket/key');
        $response = new GuzzleHttp\Psr7\Response(200);
        return [
            'NetworkException' => new GuzzleHttp\Exception\NetworkException('Connection reset by peer', $request),
            'NetworkTimeoutException' => new GuzzleHttp\Exception\NetworkTimeoutException('Operation timed out', $request),
            'ConnectException' => new GuzzleHttp\Exception\ConnectException('Connection refused', $request),
            'ConnectTimeoutException' => new GuzzleHttp\Exception\ConnectTimeoutException('Connection timed out', $request),
            'ResponseTransferException' => new GuzzleHttp\Exception\ResponseTransferException('Connection closed while receiving the body', $request, $response),
            'ResponseTimeoutException' => new GuzzleHttp\Exception\ResponseTimeoutException('Timed out while receiving the response headers', $request, $response),
        ];
    }

    /**
     * Wraps a handler and records the delay option of each attempt.
     */
    private static function recordHandler(callable $handler, array &$calls): callable
    {
        return static function ($request, array $options) use ($handler, &$calls) {
            $calls[] = $options['delay'] ?? null;
            return $handler($request, $options);
        };
    }

    private static function newClient(callable $handler, ?string $endpoint = null): ClientImpl
    {
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());
        $cfg->setRetryer(new Retry\StandardRetryer(
            self::MAX_ATTEMPTS,
            null,
            null,
            null,
            new Retry\FixedDelayBackoff(self::BACKOFF)
        ));
        if ($endpoint !== null) {
            $cfg->setEndpoint($endpoint);
            $cfg->setConnectTimeout(2.0);
        }
        return new ClientImpl($cfg, ['handler' => $handler]);
    }

    private static function newInput(): OperationInput
    {
        $input = new OperationInput('TestApi', 'PUT');
        $input->setBucket('bucket');
        $input->setKey('key');
        return $input;
    }
}
