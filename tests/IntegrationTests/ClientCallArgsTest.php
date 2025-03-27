<?php

namespace IntegrationTests;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'TestIntegration.php';

use AlibabaCloud\Oss\V2 as Oss;
use SebastianBergmann\Type\ObjectType;

class ClientCallArgsTest extends TestIntegration
{
    public function testClientCallArgs()
    {
        $client = $this->getDefaultClient();
        $bucketName = self::$bucketName;
        $key = self::randomObjectName();

        // case 1:
        $request = new \AlibabaCloud\Oss\V2\Models\PutObjectRequest($bucketName, $key);
        $request->body = \AlibabaCloud\Oss\V2\Utils::streamFor('hi oss');
        $result = $client->putObject($request);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(True, count($result->headers) > 0);
        $this->assertEquals(24, strlen($result->requestId));

        // case 2:
        $result = $client->putObject(
            new \AlibabaCloud\Oss\V2\Models\PutObjectRequest(
                bucket: $bucketName,
                key: $key,
                body: \AlibabaCloud\Oss\V2\Utils::streamFor('hi oss')
            ));
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(True, count($result->headers) > 0);
        $this->assertEquals(24, strlen($result->requestId));

        // case 3:
        $result = $client->putObject(
            request: new \AlibabaCloud\Oss\V2\Models\PutObjectRequest(
            bucket: $bucketName,
            key: $key,
            body: \AlibabaCloud\Oss\V2\Utils::streamFor('hi oss')
        ));
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(True, count($result->headers) > 0);
        $this->assertEquals(24, strlen($result->requestId));
    }
}
