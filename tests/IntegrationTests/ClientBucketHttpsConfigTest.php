<?php

namespace IntegrationTests;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'TestIntegration.php';

use AlibabaCloud\Oss\V2 as Oss;

class ClientBucketHttpsConfigTest extends TestIntegration
{
    public function testBucketHttpsConfig()
    {
        $client = $this->getDefaultClient();
        $bucketName = self::$bucketName;

        // PutBucketHttpsConfig
        $putResult = $client->putBucketHttpsConfig(new Oss\Models\PutBucketHttpsConfigRequest(
            $bucketName,
            new Oss\Models\HttpsConfiguration(
                tls: new Oss\Models\TLS(
                    tlsVersions: ['TLSv1.2', 'TLSv1.3'],
                    enable: true
                )
            )
        ));
        $this->assertEquals(200, $putResult->statusCode);
        $this->assertEquals('OK', $putResult->status);
        $this->assertEquals(True, count($putResult->headers) > 0);
        $this->assertEquals(24, strlen($putResult->requestId));

        // GetBucketHttpsConfig
        $getResult = $client->getBucketHttpsConfig(new Oss\Models\GetBucketHttpsConfigRequest(
            $bucketName
        ));
        $this->assertEquals(200, $getResult->statusCode);
        $this->assertEquals('OK', $getResult->status);
        $this->assertEquals(True, count($getResult->headers) > 0);
        $this->assertEquals(24, strlen($getResult->requestId));
    }

    public function testBucketHttpsConfigFail()
    {
        $client = $this->getDefaultClient();
        $bucketName = self::$bucketName . "-not-exist";

        // PutBucketHttpsConfig
        try {
            $putResult = $client->putBucketHttpsConfig(new Oss\Models\PutBucketHttpsConfigRequest(
                $bucketName,
                new Oss\Models\HttpsConfiguration(
                    tls: new Oss\Models\TLS(
                        tlsVersions: ['TLSv1.2', 'TLSv1.3'],
                        enable: true
                    )
                )
            ));
            $this->assertTrue(false, "should not here");
        } catch (Oss\Exception\OperationException $e) {
            $this->assertStringContainsString('Operation error PutBucketHttpsConfig', $e);
            $se = $e->getPrevious();
            $this->assertInstanceOf(Oss\Exception\ServiceException::class, $se);
            if ($se instanceof Oss\Exception\ServiceException) {
                $this->assertEquals('NoSuchBucket', $se->getErrorCode());
                $this->assertEquals(404, $se->getStatusCode());
                $this->assertEquals(24, strlen($se->getRequestId()));
            }
        }

        // GetBucketHttpsConfig
        try {
            $getResult = $client->getBucketHttpsConfig(new Oss\Models\GetBucketHttpsConfigRequest(
                $bucketName
            ));
            $this->assertTrue(false, "should not here");
        } catch (Oss\Exception\OperationException $e) {
            $this->assertStringContainsString('Operation error GetBucketHttpsConfig', $e);
            $se = $e->getPrevious();
            $this->assertInstanceOf(Oss\Exception\ServiceException::class, $se);
            if ($se instanceof Oss\Exception\ServiceException) {
                $this->assertEquals('NoSuchBucket', $se->getErrorCode());
                $this->assertEquals(404, $se->getStatusCode());
                $this->assertEquals(24, strlen($se->getRequestId()));
            }
        }
    }
}