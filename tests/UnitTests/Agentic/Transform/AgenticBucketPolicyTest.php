<?php

namespace UnitTests\Agentic\Transform;

use AlibabaCloud\Oss\V2\Agentic\Models;
use AlibabaCloud\Oss\V2\Agentic\Transform\AgenticBucketPolicy;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Utils;

class AgenticBucketPolicyTest extends \PHPUnit\Framework\TestCase
{
    public function testFromPutAgenticBucketPolicy()
    {
        try {
            AgenticBucketPolicy::fromPutAgenticBucketPolicy(new Models\PutAgenticBucketPolicyRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $policy = '{"Version":"1","Statement":[]}';
        $input = AgenticBucketPolicy::fromPutAgenticBucketPolicy(new Models\PutAgenticBucketPolicyRequest('bucket-123', $policy));
        $this->assertEquals('PutAgenticBucketPolicy', $input->getOpName());
        $this->assertEquals('PUT', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('policy', $input->getParameters());
        $this->assertEquals('application/json', $input->getHeaders()['content-type']);
        $this->assertEquals($policy, $input->getBody()->getContents());
    }

    public function testToPutAgenticBucketPolicy()
    {
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123']);
        $result = AgenticBucketPolicy::toPutAgenticBucketPolicy($output);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
    }

    public function testFromGetAgenticBucketPolicy()
    {
        try {
            AgenticBucketPolicy::fromGetAgenticBucketPolicy(new Models\GetAgenticBucketPolicyRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $input = AgenticBucketPolicy::fromGetAgenticBucketPolicy(new Models\GetAgenticBucketPolicyRequest('bucket-123'));
        $this->assertEquals('GET', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('policy', $input->getParameters());
    }

    public function testToGetAgenticBucketPolicy()
    {
        // empty
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123']);
        $result = AgenticBucketPolicy::toGetAgenticBucketPolicy($output);
        $this->assertNull($result->policy);

        $policy = '{"Version":"1","Statement":[]}';
        $output = new OperationOutput('OK', 200, ['x-oss-request-id' => '123'], Utils::streamFor($policy));
        $result = AgenticBucketPolicy::toGetAgenticBucketPolicy($output);
        $this->assertEquals($policy, $result->policy);
    }

    public function testFromDeleteAgenticBucketPolicy()
    {
        try {
            AgenticBucketPolicy::fromDeleteAgenticBucketPolicy(new Models\DeleteAgenticBucketPolicyRequest());
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $input = AgenticBucketPolicy::fromDeleteAgenticBucketPolicy(new Models\DeleteAgenticBucketPolicyRequest('bucket-123'));
        $this->assertEquals('DELETE', $input->getMethod());
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertArrayHasKey('policy', $input->getParameters());
    }

    public function testToDeleteAgenticBucketPolicy()
    {
        $output = new OperationOutput('No Content', 204, ['x-oss-request-id' => '123']);
        $result = AgenticBucketPolicy::toDeleteAgenticBucketPolicy($output);
        $this->assertEquals(204, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
    }
}
