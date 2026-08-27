<?php

namespace UnitTests\Agentic\Transform;

use AlibabaCloud\Oss\V2\Agentic\Models;
use AlibabaCloud\Oss\V2\Agentic\Transform\AgenticBucketAcl;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Utils;

class AgenticBucketAclTest extends \PHPUnit\Framework\TestCase
{
    public function testFromPutAgenticBucketAcl()
    {
        // miss bucket
        try {
            AgenticBucketAcl::fromPutAgenticBucketAcl(new Models\PutAgenticBucketAclRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        // miss acl
        try {
            AgenticBucketAcl::fromPutAgenticBucketAcl(new Models\PutAgenticBucketAclRequest('bucket-123'));
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, acl", (string)$e);
        }

        $input = AgenticBucketAcl::fromPutAgenticBucketAcl(new Models\PutAgenticBucketAclRequest('bucket-123', 'private'));
        $this->assertEquals('PutAgenticBucketAcl', $input->getOpName());
        $this->assertEquals('PUT', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('acl', $input->getParameters());
        $this->assertEquals('private', $input->getHeaders()['x-oss-acl']);
    }

    public function testToPutAgenticBucketAcl()
    {
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123']);
        $result = AgenticBucketAcl::toPutAgenticBucketAcl($output);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
    }

    public function testFromGetAgenticBucketAcl()
    {
        try {
            AgenticBucketAcl::fromGetAgenticBucketAcl(new Models\GetAgenticBucketAclRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $input = AgenticBucketAcl::fromGetAgenticBucketAcl(new Models\GetAgenticBucketAclRequest('bucket-123'));
        $this->assertEquals('GetAgenticBucketAcl', $input->getOpName());
        $this->assertEquals('GET', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('acl', $input->getParameters());
    }

    public function testToGetAgenticBucketAcl()
    {
        $body = '<?xml version="1.0" encoding="UTF-8"?>
<AccessControlPolicy>
  <Owner>
    <ID>1234</ID>
    <DisplayName>name-1</DisplayName>
  </Owner>
  <AccessControlList>
    <Grant>private</Grant>
  </AccessControlList>
</AccessControlPolicy>';
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123'], Utils::streamFor($body));
        $result = AgenticBucketAcl::toGetAgenticBucketAcl($output);
        $this->assertEquals('1234', $result->accessControlPolicy->owner->id);
        $this->assertEquals('name-1', $result->accessControlPolicy->owner->displayName);
        $this->assertEquals('private', $result->accessControlPolicy->accessControlList->grant);
    }
}
