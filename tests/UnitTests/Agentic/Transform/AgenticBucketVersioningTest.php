<?php

namespace UnitTests\Agentic\Transform;

use AlibabaCloud\Oss\V2\Agentic\Models;
use AlibabaCloud\Oss\V2\Agentic\Transform\AgenticBucketVersioning;
use AlibabaCloud\Oss\V2\Models\VersioningConfiguration;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Utils;

class AgenticBucketVersioningTest extends \PHPUnit\Framework\TestCase
{
    private function cleanXml($xml): string
    {
        return str_replace("\n", "", str_replace("\r", "", $xml));
    }

    public function testFromPutAgenticBucketVersioning()
    {
        try {
            AgenticBucketVersioning::fromPutAgenticBucketVersioning(new Models\PutAgenticBucketVersioningRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        try {
            AgenticBucketVersioning::fromPutAgenticBucketVersioning(new Models\PutAgenticBucketVersioningRequest('bucket-123'));
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, versioningConfiguration", (string)$e);
        }

        $input = AgenticBucketVersioning::fromPutAgenticBucketVersioning(new Models\PutAgenticBucketVersioningRequest(
            'bucket-123',
            new VersioningConfiguration('Enabled')
        ));
        $this->assertEquals('PutAgenticBucketVersioning', $input->getOpName());
        $this->assertEquals('PUT', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('versioning', $input->getParameters());
        $xml = '<?xml version="1.0" encoding="UTF-8"?><VersioningConfiguration><Status>Enabled</Status></VersioningConfiguration>';
        $this->assertEquals($xml, $this->cleanXml($input->getBody()->getContents()));
    }

    public function testToPutAgenticBucketVersioning()
    {
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123']);
        $result = AgenticBucketVersioning::toPutAgenticBucketVersioning($output);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
    }

    public function testFromGetAgenticBucketVersioning()
    {
        try {
            AgenticBucketVersioning::fromGetAgenticBucketVersioning(new Models\GetAgenticBucketVersioningRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $input = AgenticBucketVersioning::fromGetAgenticBucketVersioning(new Models\GetAgenticBucketVersioningRequest('bucket-123'));
        $this->assertEquals('GET', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('versioning', $input->getParameters());
    }

    public function testToGetAgenticBucketVersioning()
    {
        $body = '<?xml version="1.0" encoding="UTF-8"?>
<VersioningConfiguration>
  <Status>Enabled</Status>
</VersioningConfiguration>';
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123'], Utils::streamFor($body));
        $result = AgenticBucketVersioning::toGetAgenticBucketVersioning($output);
        $this->assertEquals('Enabled', $result->versioningConfiguration->status);
    }
}
