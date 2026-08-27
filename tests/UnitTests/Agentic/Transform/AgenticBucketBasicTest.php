<?php

namespace UnitTests\Agentic\Transform;

use AlibabaCloud\Oss\V2\Agentic\Models;
use AlibabaCloud\Oss\V2\Agentic\Transform\AgenticBucketBasic;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Utils;

class AgenticBucketBasicTest extends \PHPUnit\Framework\TestCase
{
    private function cleanXml($xml): string
    {
        return str_replace("\n", "", str_replace("\r", "", $xml));
    }

    public function testFromCreateAgenticBucket()
    {
        // miss required field
        try {
            AgenticBucketBasic::fromCreateAgenticBucket(new Models\CreateAgenticBucketRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        // minimal
        $input = AgenticBucketBasic::fromCreateAgenticBucket(new Models\CreateAgenticBucketRequest('bucket-123'));
        $this->assertEquals('CreateAgenticBucket', $input->getOpName());
        $this->assertEquals('PUT', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('agenticBucket', $input->getParameters());
        $this->assertEquals('1B2M2Y8AsgTpgAmY7PhCfg==', $input->getHeaders()['content-md5']);

        // with configuration
        $input = AgenticBucketBasic::fromCreateAgenticBucket(new Models\CreateAgenticBucketRequest(
            'bucket-123',
            new Models\CreateAgenticBucketConfiguration('IA', 'ZRS')
        ));
        $xml = '<?xml version="1.0" encoding="UTF-8"?><CreateAgenticBucketConfiguration><StorageClass>IA</StorageClass><DataRedundancyType>ZRS</DataRedundancyType></CreateAgenticBucketConfiguration>';
        $this->assertEquals($xml, $this->cleanXml($input->getBody()->getContents()));
    }

    public function testToCreateAgenticBucket()
    {
        $output = new OperationOutput();
        $result = AgenticBucketBasic::toCreateAgenticBucket($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);

        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123']);
        $result = AgenticBucketBasic::toCreateAgenticBucket($output);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
    }

    public function testFromDeleteAgenticBucket()
    {
        try {
            AgenticBucketBasic::fromDeleteAgenticBucket(new Models\DeleteAgenticBucketRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $input = AgenticBucketBasic::fromDeleteAgenticBucket(new Models\DeleteAgenticBucketRequest('bucket-123'));
        $this->assertEquals('DeleteAgenticBucket', $input->getOpName());
        $this->assertEquals('DELETE', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('agenticBucket', $input->getParameters());
    }

    public function testToDeleteAgenticBucket()
    {
        $output = new OperationOutput('No Content', 204, ['x-oss-request-id' => '123']);
        $result = AgenticBucketBasic::toDeleteAgenticBucket($output);
        $this->assertEquals(204, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
    }

    public function testFromGetAgenticBucket()
    {
        try {
            AgenticBucketBasic::fromGetAgenticBucket(new Models\GetAgenticBucketRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $input = AgenticBucketBasic::fromGetAgenticBucket(new Models\GetAgenticBucketRequest('bucket-123'));
        $this->assertEquals('GetAgenticBucket', $input->getOpName());
        $this->assertEquals('GET', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
    }

    public function testToGetAgenticBucket()
    {
        $body = '<?xml version="1.0" encoding="UTF-8"?>
<AgenticBucketInfo>
  <Name>bucket-123</Name>
  <Owner>1234</Owner>
  <Region>cn-hangzhou</Region>
  <StorageClass>Standard</StorageClass>
  <DataRedundancyType>LRS</DataRedundancyType>
  <Status>enabled</Status>
  <CreateTime>2024-01-01T00:00:00.000Z</CreateTime>
  <ACL>private</ACL>
  <Versioning>Enabled</Versioning>
  <ServerSideEncryptionRule>
    <ApplyServerSideEncryptionByDefault>
      <SSEAlgorithm>KMS</SSEAlgorithm>
    </ApplyServerSideEncryptionByDefault>
  </ServerSideEncryptionRule>
</AgenticBucketInfo>';
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123'], Utils::streamFor($body));
        $result = AgenticBucketBasic::toGetAgenticBucket($output);
        $this->assertEquals('bucket-123', $result->agenticBucketInfo->name);
        $this->assertEquals('cn-hangzhou', $result->agenticBucketInfo->region);
        $this->assertEquals('enabled', $result->agenticBucketInfo->status);
        $this->assertEquals('private', $result->agenticBucketInfo->acl);
        $this->assertEquals('Enabled', $result->agenticBucketInfo->versioning);
        $this->assertEquals('KMS', $result->agenticBucketInfo->serverSideEncryptionRule->applyServerSideEncryptionByDefault->sseAlgorithm);
    }

    public function testFromListAgenticBuckets()
    {
        // no bucket required
        $input = AgenticBucketBasic::fromListAgenticBuckets(new Models\ListAgenticBucketsRequest());
        $this->assertEquals('ListAgenticBuckets', $input->getOpName());
        $this->assertEquals('GET', $input->getMethod());
        $this->assertNull($input->getBucket());
        $this->assertArrayHasKey('agenticBucket', $input->getParameters());

        $input = AgenticBucketBasic::fromListAgenticBuckets(new Models\ListAgenticBucketsRequest('token-1', 100));
        $this->assertEquals('token-1', $input->getParameters()['continuation-token']);
        $this->assertEquals('100', $input->getParameters()['max-keys']);
    }

    public function testToListAgenticBuckets()
    {
        $body = '<?xml version="1.0" encoding="UTF-8"?>
<ListAgenticBucketsResult>
  <Region>cn-hangzhou</Region>
  <Owner>1234</Owner>
  <ContinuationToken></ContinuationToken>
  <NextContinuationToken>next-1</NextContinuationToken>
  <IsTruncated>true</IsTruncated>
  <AgenticBuckets>
    <AgenticBucket>
      <Name>b1</Name>
      <StorageClass>Standard</StorageClass>
      <DataRedundancyType>LRS</DataRedundancyType>
      <CreateTime>2024-01-01T00:00:00.000Z</CreateTime>
    </AgenticBucket>
    <AgenticBucket>
      <Name>b2</Name>
      <StorageClass>IA</StorageClass>
      <DataRedundancyType>ZRS</DataRedundancyType>
      <CreateTime>2024-01-02T00:00:00.000Z</CreateTime>
    </AgenticBucket>
  </AgenticBuckets>
</ListAgenticBucketsResult>';
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123'], Utils::streamFor($body));
        $result = AgenticBucketBasic::toListAgenticBuckets($output);
        $this->assertEquals('cn-hangzhou', $result->region);
        $this->assertEquals('1234', $result->owner);
        $this->assertEquals('next-1', $result->nextContinuationToken);
        $this->assertTrue($result->isTruncated);
        $this->assertCount(2, $result->agenticBuckets);
        $this->assertEquals('b1', $result->agenticBuckets[0]->name);
        $this->assertEquals('Standard', $result->agenticBuckets[0]->storageClass);
        $this->assertEquals('b2', $result->agenticBuckets[1]->name);
        $this->assertEquals('ZRS', $result->agenticBuckets[1]->dataRedundancyType);
    }

    public function testFromPutAgenticBucketStatus()
    {
        try {
            AgenticBucketBasic::fromPutAgenticBucketStatus(new Models\PutAgenticBucketStatusRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $input = AgenticBucketBasic::fromPutAgenticBucketStatus(new Models\PutAgenticBucketStatusRequest(
            'bucket-123',
            new Models\AgenticBucketStatus('enabled')
        ));
        $this->assertEquals('PutAgenticBucketStatus', $input->getOpName());
        $this->assertEquals('PUT', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('status', $input->getParameters());
        $xml = '<?xml version="1.0" encoding="UTF-8"?><AgenticBucketStatus><Status>enabled</Status></AgenticBucketStatus>';
        $this->assertEquals($xml, $this->cleanXml($input->getBody()->getContents()));
    }

    public function testToPutAgenticBucketStatus()
    {
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123']);
        $result = AgenticBucketBasic::toPutAgenticBucketStatus($output);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
    }

    public function testFromListBucketSpaces()
    {
        try {
            AgenticBucketBasic::fromListBucketSpaces(new Models\ListBucketSpacesRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $input = AgenticBucketBasic::fromListBucketSpaces(new Models\ListBucketSpacesRequest('bucket-123', 'pre', 'token-1', 'space-0', 50));
        $this->assertEquals('ListBucketSpaces', $input->getOpName());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('bucketSpace', $input->getParameters());
        $this->assertEquals('pre', $input->getParameters()['prefix']);
        $this->assertEquals('token-1', $input->getParameters()['continuation-token']);
        $this->assertEquals('space-0', $input->getParameters()['start-after']);
        $this->assertEquals('50', $input->getParameters()['max-keys']);
    }

    public function testToListBucketSpaces()
    {
        $body = '<?xml version="1.0" encoding="UTF-8"?>
<ListBucketSpacesResult>
  <Owner>
    <ID>1234</ID>
    <DisplayName>name-1</DisplayName>
  </Owner>
  <Prefix>pre</Prefix>
  <MaxKeys>50</MaxKeys>
  <ContinuationToken></ContinuationToken>
  <NextContinuationToken>next-1</NextContinuationToken>
  <StartAfter>space-0</StartAfter>
  <IsTruncated>false</IsTruncated>
  <BucketSpaces>
    <BucketSpace>
      <Name>space-1</Name>
      <Location>cn-hangzhou</Location>
      <CreationDate>2024-01-01T00:00:00.000Z</CreationDate>
      <StorageClass>Standard</StorageClass>
    </BucketSpace>
  </BucketSpaces>
</ListBucketSpacesResult>';
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123'], Utils::streamFor($body));
        $result = AgenticBucketBasic::toListBucketSpaces($output);
        $this->assertEquals('1234', $result->owner->id);
        $this->assertEquals('name-1', $result->owner->displayName);
        $this->assertEquals('pre', $result->prefix);
        $this->assertEquals(50, $result->maxKeys);
        $this->assertEquals('next-1', $result->nextContinuationToken);
        $this->assertEquals('space-0', $result->startAfter);
        $this->assertFalse($result->isTruncated);
        $this->assertCount(1, $result->bucketSpaces);
        $this->assertEquals('space-1', $result->bucketSpaces[0]->name);
        $this->assertEquals('cn-hangzhou', $result->bucketSpaces[0]->location);
        $this->assertEquals('Standard', $result->bucketSpaces[0]->storageClass);
    }
}
