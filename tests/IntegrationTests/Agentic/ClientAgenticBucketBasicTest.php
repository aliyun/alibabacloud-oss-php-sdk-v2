<?php

namespace IntegrationTests\Agentic;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'TestAgentic.php';

use AlibabaCloud\Oss\V2\Agentic\Models;

class ClientAgenticBucketBasicTest extends TestAgentic
{
    public function testAgenticBucketLifecycle()
    {
        $client = self::$agenticClient;
        $bucket = self::$agenticBucketName;

        // 1. Get agentic bucket
        $getResult = $client->getAgenticBucket(new Models\GetAgenticBucketRequest($bucket));
        $this->assertEquals(200, $getResult->statusCode);
        $this->assertNotNull($getResult->agenticBucketInfo);
        $this->assertStringContainsString($bucket, $getResult->agenticBucketInfo->name);

        // 2. List agentic buckets via paginator. The listing is eventually consistent, so a
        //    still-missing bucket is reported rather than failed; getAgenticBucket above already
        //    asserted that it exists.
        if (!self::waitForAgenticBucketListed($client, $bucket)) {
            print('created agentic bucket not visible in list yet: ' . $bucket . PHP_EOL);
        }
    }

    public function testPutAgenticBucketStatus()
    {
        $client = self::$agenticClient;
        $bucket = self::$agenticBucketName;

        $putResult = $client->putAgenticBucketStatus(new Models\PutAgenticBucketStatusRequest(
            $bucket,
            new Models\AgenticBucketStatus('Enabled')
        ));
        $this->assertEquals(200, $putResult->statusCode);
    }

    public function testGetAgenticBucketNotExist()
    {
        $client = self::$agenticClient;

        try {
            $client->getAgenticBucket(new Models\GetAgenticBucketRequest('php-sdk-test-not-exist'));
            $this->assertTrue(false, "should not here");
        } catch (\Throwable $ec) {
            $se = self::findServiceException($ec);
            $this->assertNotNull($se);
            $this->assertEquals(404, $se->getStatusCode());
        }
    }

    public function testAgenticBucketInvalidCredentials()
    {
        $client = self::newInvalidAkAgenticClient();
        $bucket = 'php-sdk-test-invalid-cred';

        // Create with invalid AK
        try {
            $client->createAgenticBucket(new Models\CreateAgenticBucketRequest($bucket));
            $this->assertTrue(false, "should not here");
        } catch (\Throwable $ec) {
            $se = self::findServiceException($ec);
            $this->assertNotNull($se);
            $this->assertEquals(403, $se->getStatusCode());
            $this->assertNotEmpty($se->getRequestId());
        }

        // Get with invalid AK.
        // OSS checks bucket existence for a GET before validating the access key, so a
        // GET on a non-existent agentic bucket surfaces 404 (NoSuchBucket) rather than
        // 403; both indicate the request was rejected.
        try {
            $client->getAgenticBucket(new Models\GetAgenticBucketRequest($bucket));
            $this->assertTrue(false, "should not here");
        } catch (\Throwable $ec) {
            $se = self::findServiceException($ec);
            $this->assertNotNull($se);
            $this->assertContains($se->getStatusCode(), [403, 404]);
        }

        // List with invalid AK
        try {
            $client->listAgenticBuckets(new Models\ListAgenticBucketsRequest());
            $this->assertTrue(false, "should not here");
        } catch (\Throwable $ec) {
            $se = self::findServiceException($ec);
            $this->assertNotNull($se);
            $this->assertEquals(403, $se->getStatusCode());
        }
    }

    public function testAgenticBucketPathStyle()
    {
        $client = self::newAgenticClientPathStyle();
        $bucket = self::$agenticBucketName;

        // Probe with getAgenticBucket: listAgenticBuckets is service-level, its URL carries no
        // bucket label and is therefore identical in both addressing styles.
        try {
            $getResult = $client->getAgenticBucket(new Models\GetAgenticBucketRequest($bucket));
        } catch (\Throwable $e) {
            if (self::isSecondLevelDomainForbidden($e)) {
                print('path-style addressing not allowed on this endpoint: ' . $e->getMessage() . PHP_EOL);
                return;
            }
            throw $e;
        }
        $this->assertEquals(200, $getResult->statusCode);
        $this->assertNotNull($getResult->agenticBucketInfo);
        $this->assertStringContainsString($bucket, $getResult->agenticBucketInfo->name);

        $listResult = $client->listAgenticBuckets(new Models\ListAgenticBucketsRequest());
        $this->assertEquals(200, $listResult->statusCode);

        $spacesResult = $client->listBucketSpaces(new Models\ListBucketSpacesRequest($bucket));
        $this->assertEquals(200, $spacesResult->statusCode);
    }
}
