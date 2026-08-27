<?php

namespace UnitTests\Agentic\Transform;

use AlibabaCloud\Oss\V2\Agentic\Models;
use AlibabaCloud\Oss\V2\Agentic\Transform\AgenticBucketEncryption;
use AlibabaCloud\Oss\V2\Models\ServerSideEncryptionRule;
use AlibabaCloud\Oss\V2\Models\ApplyServerSideEncryptionByDefault;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Utils;

class AgenticBucketEncryptionTest extends \PHPUnit\Framework\TestCase
{
    private function cleanXml($xml): string
    {
        return str_replace("\n", "", str_replace("\r", "", $xml));
    }

    public function testFromPutAgenticBucketEncryption()
    {
        try {
            AgenticBucketEncryption::fromPutAgenticBucketEncryption(new Models\PutAgenticBucketEncryptionRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        try {
            AgenticBucketEncryption::fromPutAgenticBucketEncryption(new Models\PutAgenticBucketEncryptionRequest('bucket-123'));
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, serverSideEncryptionRule", (string)$e);
        }

        $input = AgenticBucketEncryption::fromPutAgenticBucketEncryption(new Models\PutAgenticBucketEncryptionRequest(
            'bucket-123',
            new ServerSideEncryptionRule(new ApplyServerSideEncryptionByDefault(sseAlgorithm: 'AES256'))
        ));
        $this->assertEquals('PutAgenticBucketEncryption', $input->getOpName());
        $this->assertEquals('PUT', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('encryption', $input->getParameters());
        $xml = '<?xml version="1.0" encoding="UTF-8"?><ServerSideEncryptionRule><ApplyServerSideEncryptionByDefault><SSEAlgorithm>AES256</SSEAlgorithm></ApplyServerSideEncryptionByDefault></ServerSideEncryptionRule>';
        $this->assertEquals($xml, $this->cleanXml($input->getBody()->getContents()));
    }

    public function testToPutAgenticBucketEncryption()
    {
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123']);
        $result = AgenticBucketEncryption::toPutAgenticBucketEncryption($output);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
    }

    public function testFromGetAgenticBucketEncryption()
    {
        try {
            AgenticBucketEncryption::fromGetAgenticBucketEncryption(new Models\GetAgenticBucketEncryptionRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $input = AgenticBucketEncryption::fromGetAgenticBucketEncryption(new Models\GetAgenticBucketEncryptionRequest('bucket-123'));
        $this->assertEquals('GET', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('encryption', $input->getParameters());
    }

    public function testToGetAgenticBucketEncryption()
    {
        $body = '<?xml version="1.0" encoding="UTF-8"?>
<ServerSideEncryptionRule>
  <ApplyServerSideEncryptionByDefault>
    <SSEAlgorithm>KMS</SSEAlgorithm>
    <KMSMasterKeyID>key-1</KMSMasterKeyID>
  </ApplyServerSideEncryptionByDefault>
</ServerSideEncryptionRule>';
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123'], Utils::streamFor($body));
        $result = AgenticBucketEncryption::toGetAgenticBucketEncryption($output);
        $this->assertEquals('KMS', $result->serverSideEncryptionRule->applyServerSideEncryptionByDefault->sseAlgorithm);
        $this->assertEquals('key-1', $result->serverSideEncryptionRule->applyServerSideEncryptionByDefault->kmsMasterKeyID);
    }

    public function testFromDeleteAgenticBucketEncryption()
    {
        try {
            AgenticBucketEncryption::fromDeleteAgenticBucketEncryption(new Models\DeleteAgenticBucketEncryptionRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $input = AgenticBucketEncryption::fromDeleteAgenticBucketEncryption(new Models\DeleteAgenticBucketEncryptionRequest('bucket-123'));
        $this->assertEquals('DELETE', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('encryption', $input->getParameters());
    }

    public function testToDeleteAgenticBucketEncryption()
    {
        $output = new OperationOutput('No Content', 204, ['x-oss-request-id' => '123']);
        $result = AgenticBucketEncryption::toDeleteAgenticBucketEncryption($output);
        $this->assertEquals(204, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
    }
}
