<?php

namespace IntegrationTests\Agentic;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'TestAgentic.php';

use AlibabaCloud\Oss\V2 as Oss;
use AlibabaCloud\Oss\V2\Agentic\Models;

class ClientAgenticBucketSpaceTest extends TestAgentic
{
    public function testListBucketSpaces()
    {
        $client = self::$agenticClient;
        $bucket = self::$agenticBucketName;

        $listResult = $client->listBucketSpaces(new Models\ListBucketSpacesRequest($bucket));
        $this->assertNotNull($listResult);
        $this->assertEquals(200, $listResult->statusCode);
    }

    /**
     * Bucket space lifecycle through a plain client: the space is addressed by its full physical
     * name, and creating it requires the parent agentic bucket's full name in the request.
     */
    public function testBucketSpaceLifecycle()
    {
        $client = self::$agenticClient;
        $bucket = self::$agenticBucketName;
        $spacePrefix = self::genBucketSpaceName();
        $spaceFullName = self::buildFullName($spacePrefix, self::BUCKET_SPACE_SUFFIX);
        $plainClient = self::newPlainClient();

        try {
            $putResult = $plainClient->putBucket(new Oss\Models\PutBucketRequest(
                $spaceFullName,
                agenticBucket: self::buildFullName($bucket, self::AGENTIC_BUCKET_SUFFIX)
            ));
            $this->assertNotNull($putResult);
            $this->assertEquals(200, $putResult->statusCode);
            self::waitFor(1);

            $infoResult = $plainClient->getBucketInfo(new Oss\Models\GetBucketInfoRequest($spaceFullName));
            $this->assertEquals(200, $infoResult->statusCode);
            $this->assertEquals('AgenticBucketSpace', $infoResult->bucketInfo->bucketResourceType);
            $this->assertNotEmpty($infoResult->bucketInfo->agenticBucketName);

            $listResult = $client->listBucketSpaces(new Models\ListBucketSpacesRequest($bucket, $spacePrefix));
            $this->assertEquals(200, $listResult->statusCode);
            $found = false;
            foreach ($listResult->bucketSpaces ?? [] as $space) {
                if ($space->name === $spaceFullName) {
                    $found = true;
                }
            }
            $this->assertTrue($found, "created bucket space should appear in list");
        } finally {
            // A non-empty bucket space cannot be deleted, so drain it first.
            self::cleanBucketSpaceObjects($spaceFullName);
            self::deleteBucketSpaceQuietly($spaceFullName);
        }
    }

    /**
     * Bucket space lifecycle through the BucketSpaceClient: the short name is expanded to
     * {space}-{accountId}-{region}-bs-apsr, the parent still has to be given as a full name.
     */
    public function testBucketSpaceClientShortName()
    {
        $client = self::$agenticClient;
        $bucket = self::$agenticBucketName;
        $spacePrefix = self::genBucketSpaceName();
        $spaceFullName = self::buildFullName($spacePrefix, self::BUCKET_SPACE_SUFFIX);
        $bsClient = self::newBucketSpaceClient();

        try {
            $putResult = $bsClient->putBucket(new Oss\Models\PutBucketRequest(
                $spacePrefix,
                agenticBucket: self::buildFullName($bucket, self::AGENTIC_BUCKET_SUFFIX)
            ));
            $this->assertEquals(200, $putResult->statusCode);
            self::waitFor(1);

            $infoResult = $bsClient->getBucketInfo(new Oss\Models\GetBucketInfoRequest($spacePrefix));
            $this->assertEquals(200, $infoResult->statusCode);
            $this->assertEquals('AgenticBucketSpace', $infoResult->bucketInfo->bucketResourceType);
            $this->assertNotEmpty($infoResult->bucketInfo->agenticBucketName);

            // Cross-check the expansion: the listed physical name must be the full name.
            $listResult = $client->listBucketSpaces(new Models\ListBucketSpacesRequest($bucket, $spacePrefix));
            $this->assertEquals(200, $listResult->statusCode);
            $found = false;
            foreach ($listResult->bucketSpaces ?? [] as $space) {
                if ($space->name === $spaceFullName) {
                    $found = true;
                }
            }
            $this->assertTrue($found, "bucket space created via BucketSpaceClient should appear in list");
        } finally {
            self::cleanBucketSpaceObjects($spaceFullName);
            self::deleteBucketSpaceQuietly($spaceFullName);
        }
    }

    public function testBucketSpaceObjectOperations()
    {
        $bucket = self::$agenticBucketName;
        $spacePrefix = self::genBucketSpaceName();
        $spaceFullName = self::buildFullName($spacePrefix, self::BUCKET_SPACE_SUFFIX);
        $bsClient = self::newBucketSpaceClient();

        try {
            $putBucketResult = $bsClient->putBucket(new Oss\Models\PutBucketRequest(
                $spacePrefix,
                agenticBucket: self::buildFullName($bucket, self::AGENTIC_BUCKET_SUFFIX)
            ));
            $this->assertEquals(200, $putBucketResult->statusCode);
            self::waitFor(1);

            $key = 'php-sdk-test-object-' . strval(time());
            $putObjRequest = new Oss\Models\PutObjectRequest($spacePrefix, $key);
            $putObjRequest->body = Oss\Utils::streamFor('hello agentic');
            $putObjResult = $bsClient->putObject($putObjRequest);
            $this->assertEquals(200, $putObjResult->statusCode);

            $getObjResult = $bsClient->getObject(new Oss\Models\GetObjectRequest($spacePrefix, $key));
            $this->assertEquals(200, $getObjResult->statusCode);
            $this->assertEquals('hello agentic', $getObjResult->body->getContents());

            $delObjResult = $bsClient->deleteObject(new Oss\Models\DeleteObjectRequest($spacePrefix, $key));
            $this->assertEquals(204, $delObjResult->statusCode);

            $aclResult = $bsClient->getBucketAcl(new Oss\Models\GetBucketAclRequest($spacePrefix));
            $this->assertEquals(200, $aclResult->statusCode);
            $this->assertNotNull($aclResult->accessControlList);
        } finally {
            self::cleanBucketSpaceObjects($spaceFullName);
            self::deleteBucketSpaceQuietly($spaceFullName);
        }
    }

    /**
     * The bucket space endpoint is a different domain than the agentic bucket one, so its
     * path-style support has to be probed separately.
     */
    public function testBucketSpaceObjectOperationsPathStyle()
    {
        $bucket = self::$agenticBucketName;
        $spacePrefix = self::genBucketSpaceName();
        $spaceFullName = self::buildFullName($spacePrefix, self::BUCKET_SPACE_SUFFIX);
        $bsClient = self::newBucketSpaceClient();

        try {
            // Create the space with the default addressing style: only the object operations below
            // are under test here.
            $putBucketResult = $bsClient->putBucket(new Oss\Models\PutBucketRequest(
                $spacePrefix,
                agenticBucket: self::buildFullName($bucket, self::AGENTIC_BUCKET_SUFFIX)
            ));
            $this->assertEquals(200, $putBucketResult->statusCode);
            self::waitFor(1);

            $pathClient = self::newBucketSpaceClientPathStyle();
            $key = 'php-sdk-test-object-path-style-' . strval(time());

            $putObjRequest = new Oss\Models\PutObjectRequest($spacePrefix, $key);
            $putObjRequest->body = Oss\Utils::streamFor('hello path style');
            try {
                $putObjResult = $pathClient->putObject($putObjRequest);
            } catch (\Throwable $e) {
                if (self::isSecondLevelDomainForbidden($e)) {
                    print('path-style addressing not allowed on the bucket space endpoint: '
                        . $e->getMessage() . PHP_EOL);
                    return;
                }
                throw $e;
            }
            $this->assertEquals(200, $putObjResult->statusCode);

            $getObjResult = $pathClient->getObject(new Oss\Models\GetObjectRequest($spacePrefix, $key));
            $this->assertEquals(200, $getObjResult->statusCode);
            $this->assertEquals('hello path style', $getObjResult->body->getContents());

            $delObjResult = $pathClient->deleteObject(new Oss\Models\DeleteObjectRequest($spacePrefix, $key));
            $this->assertEquals(204, $delObjResult->statusCode);

            $aclResult = $pathClient->getBucketAcl(new Oss\Models\GetBucketAclRequest($spacePrefix));
            $this->assertEquals(200, $aclResult->statusCode);
            $this->assertNotNull($aclResult->accessControlList);
        } finally {
            self::cleanBucketSpaceObjects($spaceFullName);
            self::deleteBucketSpaceQuietly($spaceFullName);
        }
    }
}
