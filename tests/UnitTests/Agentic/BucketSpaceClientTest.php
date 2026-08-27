<?php

namespace UnitTests\Agentic;

use AlibabaCloud\Oss\V2\Agentic\AgenticProvider;
use AlibabaCloud\Oss\V2\Agentic\BucketSpaceClient;
use AlibabaCloud\Oss\V2\Client;
use AlibabaCloud\Oss\V2\Config;
use AlibabaCloud\Oss\V2\Credentials;
use AlibabaCloud\Oss\V2\Models;
use AlibabaCloud\Oss\V2\OperationInput;
use AlibabaCloud\Oss\V2\Types\BucketNameResolver;
use AlibabaCloud\Oss\V2\Types\EndpointProvider;
use GuzzleHttp;

class BucketSpaceClientTest extends \PHPUnit\Framework\TestCase
{
    private function reflectClientImpl(Client $client)
    {
        $ro = new \ReflectionObject($client);
        $pImpl = $ro->getProperty('client'); // ClientImpl
        if (PHP_VERSION_ID < 80100) {
            $pImpl->setAccessible(true);
        }
        return $pImpl->getValue($client);
    }

    private function reflectOptions(Client $client, string $property): array
    {
        $impl = $this->reflectClientImpl($client);
        $roImpl = new \ReflectionObject($impl);
        $p = $roImpl->getProperty($property);
        if (PHP_VERSION_ID < 80100) {
            $p->setAccessible(true);
        }
        return $p->getValue($impl);
    }

    public function testNewClientReturnsClient()
    {
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setAccountId('1234567890');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());

        $client = BucketSpaceClient::newClient($cfg);
        $this->assertInstanceOf(Client::class, $client);
    }

    public function testClientConstructionWiring()
    {
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setAccountId('1234567890');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());

        $client = BucketSpaceClient::newClient($cfg);
        $sdkOptions = $this->reflectOptions($client, 'sdkOptions');

        $this->assertInstanceOf(AgenticProvider::class, $sdkOptions['endpoint_provider']);
        $this->assertInstanceOf(EndpointProvider::class, $sdkOptions['endpoint_provider']);
        $this->assertInstanceOf(BucketNameResolver::class, $sdkOptions['bucket_name_resolver']);
        // one instance wired to both slots
        $this->assertSame($sdkOptions['endpoint_provider'], $sdkOptions['bucket_name_resolver']);

        // bucket spaces resolve with the bs-apsr suffix
        $input = new OperationInput('PutObject', 'PUT', null, null, null, 'my-space', 'my-key');
        $this->assertEquals(
            'my-space-1234567890-cn-hangzhou-bs-apsr',
            $sdkOptions['bucket_name_resolver']->buildBucketName($input)
        );
        $this->assertEquals(
            'https://my-space-1234567890-cn-hangzhou-bs-apsr.oss-cn-hangzhou.aliyuncs.com/my-key',
            $sdkOptions['endpoint_provider']->buildUrl($input)
        );
    }

    public function testHostRoutingUseVirtualHostedAlias()
    {
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setAccountId('1234567890');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());
        $cfg->setUseVirtualHostedAlias(true);

        $mock = new GuzzleHttp\Handler\MockHandler([new GuzzleHttp\Psr7\Response()]);
        $client = BucketSpaceClient::newClient($cfg, ['handler' => $mock]);

        $request = new Models\PutObjectRequest('my-space', 'test.txt');
        $request->body = GuzzleHttp\Psr7\Utils::streamFor('hello');
        $client->putObject($request);

        $httpRequest = $mock->getLastRequest();
        $this->assertEquals('PUT', $httpRequest->getMethod());
        $this->assertEquals(
            'my-space-alias-bs-apsr.oss-cn-hangzhou.aliyuncs.com',
            $httpRequest->getUri()->getHost()
        );
        $this->assertEquals('/test.txt', $httpRequest->getUri()->getPath());
    }

    public function testUpdateUserAgent()
    {
        // default agentic user agent
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setAccountId('1234567890');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());

        $client = BucketSpaceClient::newClient($cfg);
        $innerOptions = $this->reflectOptions($client, 'innerOptions');
        $this->assertStringEndsWith('/agentic-client', $innerOptions['user_agent']);

        // user-supplied user agent is appended
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setAccountId('1234567890');
        $cfg->setUserAgent('my-agent');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());

        $client = BucketSpaceClient::newClient($cfg);
        $innerOptions = $this->reflectOptions($client, 'innerOptions');
        $this->assertStringContainsString('agentic-client/my-agent', $innerOptions['user_agent']);
    }

    public function testInvalidAccountIdDeferredToOperation()
    {
        // building the client with an invalid account id must NOT throw
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setAccountId('abc');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());

        $client = BucketSpaceClient::newClient($cfg);
        $this->assertInstanceOf(Client::class, $client);

        // the error is surfaced when an operation is invoked
        try {
            $client->invokeOperation(new OperationInput('ListObjectsV2', 'GET', null, null, null, 'my-space'));
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString('invalid account id', (string)$e);
        }
    }
}
