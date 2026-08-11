<?php

namespace UnitTests\Agentic;

use AlibabaCloud\Oss\V2\Agentic\AgenticBucketClient;
use AlibabaCloud\Oss\V2\Agentic\Models;
use AlibabaCloud\Oss\V2\Config;
use AlibabaCloud\Oss\V2\Credentials;
use GuzzleHttp;

class AgenticBucketClientTest extends \PHPUnit\Framework\TestCase
{
    private function newConfig(): Config
    {
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setAccountId('1234567890');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());
        return $cfg;
    }

    public function testHostRoutingBucketScopedOp()
    {
        // A bucket-scoped op routes to the derived bucket host
        $mock = new GuzzleHttp\Handler\MockHandler([new GuzzleHttp\Psr7\Response()]);
        $client = new AgenticBucketClient($this->newConfig(), ['handler' => $mock]);

        $client->getAgenticBucket(new Models\GetAgenticBucketRequest('my-bucket'));

        $request = $mock->getLastRequest();
        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals(
            'my-bucket-1234567890-cn-hangzhou-ab-apsr.oss-cn-hangzhou.aliyuncs.com',
            $request->getUri()->getHost()
        );
    }

    public function testHostRoutingRegionLevelOp()
    {
        // A region-level op sets no bucket and routes to the region host
        $body = '<?xml version="1.0" encoding="UTF-8"?><ListAgenticBucketsResult></ListAgenticBucketsResult>';
        $mock = new GuzzleHttp\Handler\MockHandler([new GuzzleHttp\Psr7\Response(200, [], $body)]);
        $client = new AgenticBucketClient($this->newConfig(), ['handler' => $mock]);

        $client->listAgenticBuckets(new Models\ListAgenticBucketsRequest());

        $request = $mock->getLastRequest();
        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals('oss-cn-hangzhou.aliyuncs.com', $request->getUri()->getHost());
    }

    public function testHostRoutingRespectsCustomEndpoint()
    {
        // A custom endpoint is used as the base authority for the derived host
        $cfg = $this->newConfig();
        $cfg->setEndpoint('oss-cn-hangzhou-internal.aliyuncs.com');

        $mock = new GuzzleHttp\Handler\MockHandler([new GuzzleHttp\Psr7\Response()]);
        $client = new AgenticBucketClient($cfg, ['handler' => $mock]);

        $client->getAgenticBucket(new Models\GetAgenticBucketRequest('my-bucket'));

        $request = $mock->getLastRequest();
        $this->assertEquals(
            'my-bucket-1234567890-cn-hangzhou-ab-apsr.oss-cn-hangzhou-internal.aliyuncs.com',
            $request->getUri()->getHost()
        );
    }

    public function testHostRoutingCustomEndpointWithScheme()
    {
        // An endpoint carrying an explicit scheme is honored for both scheme and host
        $cfg = $this->newConfig();
        $cfg->setEndpoint('https://oss-cn-hangzhou-internal.aliyuncs.com');

        $mock = new GuzzleHttp\Handler\MockHandler([new GuzzleHttp\Psr7\Response()]);
        $client = new AgenticBucketClient($cfg, ['handler' => $mock]);

        $client->getAgenticBucket(new Models\GetAgenticBucketRequest('my-bucket'));

        $request = $mock->getLastRequest();
        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals(
            'my-bucket-1234567890-cn-hangzhou-ab-apsr.oss-cn-hangzhou-internal.aliyuncs.com',
            $request->getUri()->getHost()
        );
    }

    public function testHostRoutingUseVirtualHostedAlias()
    {
        $cfg = $this->newConfig();
        // sign for real so the alias host also exercises the signing path
        $cfg->setCredentialsProvider(new Credentials\StaticCredentialsProvider('ak', 'sk'));
        $cfg->setUseVirtualHostedAlias(true);

        $mock = new GuzzleHttp\Handler\MockHandler([new GuzzleHttp\Psr7\Response()]);
        $client = new AgenticBucketClient($cfg, ['handler' => $mock]);

        $client->getAgenticBucket(new Models\GetAgenticBucketRequest('my-bucket'));

        $request = $mock->getLastRequest();
        $this->assertEquals('https', $request->getUri()->getScheme());
        $this->assertEquals(
            'my-bucket-alias-ab-apsr.oss-cn-hangzhou.aliyuncs.com',
            $request->getUri()->getHost()
        );
        $this->assertStringStartsWith('OSS4-HMAC-SHA256 ', $request->getHeaderLine('Authorization'));
    }

    public function testUseVirtualHostedAliasStillRequiresAccountId()
    {
        $cfg = Config::loadDefault();
        $cfg->setRegion('cn-hangzhou');
        $cfg->setCredentialsProvider(new Credentials\AnonymousCredentialsProvider());
        $cfg->setUseVirtualHostedAlias(true);

        $mock = new GuzzleHttp\Handler\MockHandler([new GuzzleHttp\Psr7\Response()]);
        $client = new AgenticBucketClient($cfg, ['handler' => $mock]);

        try {
            $client->getAgenticBucket(new Models\GetAgenticBucketRequest('my-bucket'));
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString('AccountId', $e->getMessage());
        }
        $this->assertNull($mock->getLastRequest());
    }

    public function testUsePathStyleWinsOverVirtualHostedAlias()
    {
        $cfg = $this->newConfig();
        $cfg->setUsePathStyle(true);
        $cfg->setUseVirtualHostedAlias(true);

        $mock = new GuzzleHttp\Handler\MockHandler([new GuzzleHttp\Psr7\Response()]);
        $client = new AgenticBucketClient($cfg, ['handler' => $mock]);

        $client->getAgenticBucket(new Models\GetAgenticBucketRequest('my-bucket'));

        $request = $mock->getLastRequest();
        $this->assertEquals('oss-cn-hangzhou.aliyuncs.com', $request->getUri()->getHost());
        $this->assertEquals('/my-bucket-1234567890-cn-hangzhou-ab-apsr/', $request->getUri()->getPath());
    }
}
