<?php

namespace UnitTests\Agentic;

use AlibabaCloud\Oss\V2\Agentic\AgenticBucketClient;
use AlibabaCloud\Oss\V2\Agentic\AgenticProvider;
use AlibabaCloud\Oss\V2\Agentic\Models;
use AlibabaCloud\Oss\V2\Config;
use AlibabaCloud\Oss\V2\Credentials;
use AlibabaCloud\Oss\V2\OperationInput;
use AlibabaCloud\Oss\V2\Types\BucketNameResolver;
use AlibabaCloud\Oss\V2\Types\EndpointProvider;
use GuzzleHttp;

class AgenticProviderTest extends \PHPUnit\Framework\TestCase
{
    private function newEndpoint(): GuzzleHttp\Psr7\Uri
    {
        return new GuzzleHttp\Psr7\Uri('https://oss-cn-hangzhou.aliyuncs.com');
    }

    public function testBuildBucketName()
    {
        $provider = new AgenticProvider($this->newEndpoint(), '1234567890', 'cn-hangzhou', 'ab-apsr');

        $input = new OperationInput('GetAgenticBucket', 'GET', null, null, null, 'my-bucket');
        $this->assertEquals(
            'my-bucket-1234567890-cn-hangzhou-ab-apsr',
            $provider->buildBucketName($input)
        );

        // no bucket -> null
        $input = new OperationInput('ListAgenticBuckets', 'GET');
        $this->assertNull($provider->buildBucketName($input));
    }

    public function testBuildUrl()
    {
        $provider = new AgenticProvider($this->newEndpoint(), '1234567890', 'cn-hangzhou', 'ab-apsr');

        // with bucket
        $input = new OperationInput('GetAgenticBucket', 'GET', null, null, null, 'my-bucket');
        $this->assertEquals(
            'https://my-bucket-1234567890-cn-hangzhou-ab-apsr.oss-cn-hangzhou.aliyuncs.com/',
            $provider->buildUrl($input)
        );

        // without bucket
        $input = new OperationInput('ListAgenticBuckets', 'GET');
        $this->assertEquals(
            'https://oss-cn-hangzhou.aliyuncs.com/',
            $provider->buildUrl($input)
        );

        // with bucket and key
        $input = new OperationInput('GetObject', 'GET', null, null, null, 'my-bucket', 'my-key');
        $this->assertEquals(
            'https://my-bucket-1234567890-cn-hangzhou-ab-apsr.oss-cn-hangzhou.aliyuncs.com/my-key',
            $provider->buildUrl($input)
        );
    }

    public function testBuildUrlPathStyle()
    {
        $provider = new AgenticProvider($this->newEndpoint(), '1234567890', 'cn-hangzhou', 'ab-apsr', 'path');

        // with bucket -> physical bucket name in the path
        $input = new OperationInput('GetAgenticBucket', 'GET', null, null, null, 'my-bucket');
        $this->assertEquals(
            'https://oss-cn-hangzhou.aliyuncs.com/my-bucket-1234567890-cn-hangzhou-ab-apsr/',
            $provider->buildUrl($input)
        );

        // with bucket and key
        $input = new OperationInput('GetObject', 'GET', null, null, null, 'my-bucket', 'my-key');
        $this->assertEquals(
            'https://oss-cn-hangzhou.aliyuncs.com/my-bucket-1234567890-cn-hangzhou-ab-apsr/my-key',
            $provider->buildUrl($input)
        );

        // without bucket -> bare endpoint authority
        $input = new OperationInput('ListAgenticBuckets', 'GET');
        $this->assertEquals(
            'https://oss-cn-hangzhou.aliyuncs.com/',
            $provider->buildUrl($input)
        );
    }

    public function testClientConstructionWiringPathStyle()
    {
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setAccountId('1234567890');
        $cfg->setUsePathStyle(true);
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());

        $client = new AgenticBucketClient($cfg);
        $sdkOptions = $this->reflectOptions($client, 'sdkOptions');

        $input = new OperationInput('GetAgenticBucket', 'GET', null, null, null, 'my-bucket');
        $this->assertEquals(
            'https://oss-cn-hangzhou.aliyuncs.com/my-bucket-1234567890-cn-hangzhou-ab-apsr/',
            $sdkOptions['endpoint_provider']->buildUrl($input)
        );
    }

    public function testBucketSpaceProvider()
    {
        $provider = new AgenticProvider($this->newEndpoint(), '1234567890', 'cn-hangzhou', 'bs-apsr');

        $input = new OperationInput('ListBucketSpaces', 'GET', null, null, null, 'my-bucket');
        $this->assertEquals(
            'my-bucket-1234567890-cn-hangzhou-bs-apsr',
            $provider->buildBucketName($input)
        );
        $this->assertEquals(
            'https://my-bucket-1234567890-cn-hangzhou-bs-apsr.oss-cn-hangzhou.aliyuncs.com/',
            $provider->buildUrl($input)
        );
    }

    public function testMissingRequiredFields()
    {
        $input = new OperationInput('GetAgenticBucket', 'GET', null, null, null, 'my-bucket');

        // missing accountId
        $p1 = new AgenticProvider($this->newEndpoint(), '', 'cn-hangzhou', 'ab-apsr');
        try {
            $p1->buildUrl($input);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString('AccountId', $e->getMessage());
        }
        try {
            $p1->buildBucketName($input);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString('AccountId', $e->getMessage());
        }

        // missing region
        $p2 = new AgenticProvider($this->newEndpoint(), '1234567890', '', 'ab-apsr');
        try {
            $p2->buildUrl($input);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString('Region', $e->getMessage());
        }
        try {
            $p2->buildBucketName($input);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString('Region', $e->getMessage());
        }

        // no bucket: validation is skipped, no error
        $this->assertNull($p2->buildBucketName(new OperationInput('ListAgenticBuckets', 'GET')));
    }

    public function testHostLabelTooLong()
    {
        // full name = "{bucket}-1234567890-cn-hangzhou-ab-apsr" -> len(bucket) + 31
        $suffixPart = '-1234567890-cn-hangzhou-ab-apsr';
        $vh = new AgenticProvider($this->newEndpoint(), '1234567890', 'cn-hangzhou', 'ab-apsr');

        // boundary: full name == 63 (bucket 32) is allowed in virtual-hosted style
        $okName = str_repeat('a', 32);
        $this->assertEquals(63, strlen($okName . $suffixPart));
        $input = new OperationInput('GetAgenticBucket', 'GET', null, null, null, $okName);
        $this->assertEquals(
            'https://' . $okName . $suffixPart . '.oss-cn-hangzhou.aliyuncs.com/',
            $vh->buildUrl($input)
        );

        // over limit: full name == 64 (bucket 33) is rejected in virtual-hosted style
        $longName = str_repeat('a', 33);
        $this->assertEquals(64, strlen($longName . $suffixPart));
        $input = new OperationInput('GetAgenticBucket', 'GET', null, null, null, $longName);
        try {
            $vh->buildUrl($input);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString('exceeds the maximum length of 63 characters', $e->getMessage());
        }

        // path style has no DNS label limit, so the same long name is fine
        $path = new AgenticProvider($this->newEndpoint(), '1234567890', 'cn-hangzhou', 'ab-apsr', 'path');
        $this->assertEquals(
            'https://oss-cn-hangzhou.aliyuncs.com/' . $longName . $suffixPart . '/',
            $path->buildUrl($input)
        );
    }

    private function reflectClientImpl(AgenticBucketClient $client)
    {
        $ro = new \ReflectionObject($client);
        $pClient = $ro->getProperty('client'); // Client
        if (PHP_VERSION_ID < 80100) {
            $pClient->setAccessible(true);
        }
        $inner = $pClient->getValue($client); // Client

        $roInner = new \ReflectionObject($inner);
        $pImpl = $roInner->getProperty('client'); // ClientImpl
        if (PHP_VERSION_ID < 80100) {
            $pImpl->setAccessible(true);
        }
        return $pImpl->getValue($inner);
    }

    private function reflectOptions(AgenticBucketClient $client, string $property): array
    {
        $impl = $this->reflectClientImpl($client);
        $roImpl = new \ReflectionObject($impl);
        $p = $roImpl->getProperty($property);
        if (PHP_VERSION_ID < 80100) {
            $p->setAccessible(true);
        }
        return $p->getValue($impl);
    }

    public function testClientConstructionWiring()
    {
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setAccountId('1234567890');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());

        $client = new AgenticBucketClient($cfg);
        $this->assertInstanceOf(AgenticBucketClient::class, $client);

        $sdkOptions = $this->reflectOptions($client, 'sdkOptions');

        $this->assertInstanceOf(AgenticProvider::class, $sdkOptions['endpoint_provider']);
        $this->assertInstanceOf(EndpointProvider::class, $sdkOptions['endpoint_provider']);
        $this->assertInstanceOf(BucketNameResolver::class, $sdkOptions['bucket_name_resolver']);
        // one instance wired to both slots
        $this->assertSame($sdkOptions['endpoint_provider'], $sdkOptions['bucket_name_resolver']);

        // wired provider resolves against the configured region/account/endpoint
        $input = new OperationInput('GetAgenticBucket', 'GET', null, null, null, 'my-bucket');
        $this->assertEquals(
            'my-bucket-1234567890-cn-hangzhou-ab-apsr',
            $sdkOptions['bucket_name_resolver']->buildBucketName($input)
        );
    }

    public function testUpdateUserAgent()
    {
        // default agentic user agent
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setAccountId('1234567890');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());

        $client = new AgenticBucketClient($cfg);
        $innerOptions = $this->reflectOptions($client, 'innerOptions');
        $this->assertStringEndsWith('/agentic-client', $innerOptions['user_agent']);

        // user-supplied user agent is appended
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setAccountId('1234567890');
        $cfg->setUserAgent('my-agent');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());

        $client = new AgenticBucketClient($cfg);
        $innerOptions = $this->reflectOptions($client, 'innerOptions');
        $this->assertStringContainsString('agentic-client/my-agent', $innerOptions['user_agent']);
    }

    public function testInvalidRegionDeferredToOperation()
    {
        // no region / no endpoint: construction succeeds, provider is not wired,
        // and the endpoint error surfaces at operation time
        $cfg = Config::loadDefault();
        $cfg->setAccountId('1234567890');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());

        $client = new AgenticBucketClient($cfg);
        $sdkOptions = $this->reflectOptions($client, 'sdkOptions');

        $this->assertNull($sdkOptions['endpoint_provider']);
        $this->assertNull($sdkOptions['bucket_name_resolver']);
    }

    public function testInvalidAccountIdDeferredToOperation()
    {
        // building the client with an invalid account id must NOT throw
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setAccountId('abc');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());

        $client = new AgenticBucketClient($cfg);
        $this->assertInstanceOf(AgenticBucketClient::class, $client);

        // the error is surfaced when an operation is invoked
        try {
            $client->listAgenticBuckets(new Models\ListAgenticBucketsRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString('invalid account id', (string)$e);
        }
    }
}
