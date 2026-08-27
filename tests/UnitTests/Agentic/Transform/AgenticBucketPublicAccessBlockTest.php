<?php

namespace UnitTests\Agentic\Transform;

use AlibabaCloud\Oss\V2\Agentic\Models;
use AlibabaCloud\Oss\V2\Agentic\Transform\AgenticBucketPublicAccessBlock;
use AlibabaCloud\Oss\V2\Models\PublicAccessBlockConfiguration;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Utils;

class AgenticBucketPublicAccessBlockTest extends \PHPUnit\Framework\TestCase
{
    private function cleanXml($xml): string
    {
        return str_replace("\n", "", str_replace("\r", "", $xml));
    }

    public function testFromPutAgenticBucketPublicAccessBlock()
    {
        try {
            AgenticBucketPublicAccessBlock::fromPutAgenticBucketPublicAccessBlock(new Models\PutAgenticBucketPublicAccessBlockRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        try {
            AgenticBucketPublicAccessBlock::fromPutAgenticBucketPublicAccessBlock(new Models\PutAgenticBucketPublicAccessBlockRequest('bucket-123'));
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, publicAccessBlockConfiguration", (string)$e);
        }

        $input = AgenticBucketPublicAccessBlock::fromPutAgenticBucketPublicAccessBlock(new Models\PutAgenticBucketPublicAccessBlockRequest(
            'bucket-123',
            new PublicAccessBlockConfiguration(true)
        ));
        $this->assertEquals('PutAgenticBucketPublicAccessBlock', $input->getOpName());
        $this->assertEquals('PUT', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('publicAccessBlock', $input->getParameters());
        $xml = '<?xml version="1.0" encoding="UTF-8"?><PublicAccessBlockConfiguration><BlockPublicAccess>true</BlockPublicAccess></PublicAccessBlockConfiguration>';
        $this->assertEquals($xml, $this->cleanXml($input->getBody()->getContents()));
    }

    public function testToPutAgenticBucketPublicAccessBlock()
    {
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123']);
        $result = AgenticBucketPublicAccessBlock::toPutAgenticBucketPublicAccessBlock($output);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
    }

    public function testFromGetAgenticBucketPublicAccessBlock()
    {
        try {
            AgenticBucketPublicAccessBlock::fromGetAgenticBucketPublicAccessBlock(new Models\GetAgenticBucketPublicAccessBlockRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $input = AgenticBucketPublicAccessBlock::fromGetAgenticBucketPublicAccessBlock(new Models\GetAgenticBucketPublicAccessBlockRequest('bucket-123'));
        $this->assertEquals('GET', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('publicAccessBlock', $input->getParameters());
    }

    public function testToGetAgenticBucketPublicAccessBlock()
    {
        $body = '<?xml version="1.0" encoding="UTF-8"?>
<PublicAccessBlockConfiguration>
  <BlockPublicAccess>true</BlockPublicAccess>
</PublicAccessBlockConfiguration>';
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123'], Utils::streamFor($body));
        $result = AgenticBucketPublicAccessBlock::toGetAgenticBucketPublicAccessBlock($output);
        $this->assertTrue($result->publicAccessBlockConfiguration->blockPublicAccess);
    }

    public function testFromDeleteAgenticBucketPublicAccessBlock()
    {
        try {
            AgenticBucketPublicAccessBlock::fromDeleteAgenticBucketPublicAccessBlock(new Models\DeleteAgenticBucketPublicAccessBlockRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $input = AgenticBucketPublicAccessBlock::fromDeleteAgenticBucketPublicAccessBlock(new Models\DeleteAgenticBucketPublicAccessBlockRequest('bucket-123'));
        $this->assertEquals('DELETE', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('publicAccessBlock', $input->getParameters());
    }

    public function testToDeleteAgenticBucketPublicAccessBlock()
    {
        $output = new OperationOutput('No Content', 204, ['x-oss-request-id' => '123']);
        $result = AgenticBucketPublicAccessBlock::toDeleteAgenticBucketPublicAccessBlock($output);
        $this->assertEquals(204, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
    }
}
