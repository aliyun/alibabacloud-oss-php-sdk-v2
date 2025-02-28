<?php

namespace UnitTests\Transform;

use AlibabaCloud\Oss\V2\Models;
use AlibabaCloud\Oss\V2\Transform\BucketHttpsConfig;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Utils;

class BucketHttpsConfigTest extends \PHPUnit\Framework\TestCase
{
    public function testFromPutBucketHttpsConfig()
    {
        // miss required field 
        try {
            $request = new Models\PutBucketHttpsConfigRequest();
            $input = BucketHttpsConfig::fromPutBucketHttpsConfig($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        try {
            $request = new Models\PutBucketHttpsConfigRequest('bucket-123');
            $input = BucketHttpsConfig::fromPutBucketHttpsConfig($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, httpsConfiguration", (string)$e);
        }

        // demo1
        $request = new Models\PutBucketHttpsConfigRequest('bucket-123', new Models\HttpsConfiguration(
            tls: new Models\TLS(
                tlsVersions: ['TLSv1.2', 'TLSv1.3'],
                enable: true
            )
        ));
        $input = BucketHttpsConfig::fromPutBucketHttpsConfig($request);
        $this->assertEquals('bucket-123', $input->getBucket());
        $xml = <<<BBB
<?xml version="1.0" encoding="UTF-8"?><HttpsConfiguration><TLS><TLSVersion>TLSv1.2</TLSVersion><TLSVersion>TLSv1.3</TLSVersion><Enable>true</Enable></TLS></HttpsConfiguration>
BBB;
        $this->assertEquals($xml, $this->cleanXml($input->getBody()->getContents()));
    }

    public function testToPutBucketHttpsConfig()
    {
        // empty output
        $output = new OperationOutput();
        $result = BucketHttpsConfig::toPutBucketHttpsConfig($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);
        $this->assertEquals('', $result->requestId);
        $this->assertEquals(0, count($result->headers));

        $output = new OperationOutput(
            'OK',
            200,
            ['x-oss-request-id' => '123']
        );
        $result = BucketHttpsConfig::toPutBucketHttpsConfig($output);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
        $this->assertEquals(1, count($result->headers));
        $this->assertEquals('123', $result->headers['x-oss-request-id']);
    }

    public function testFromGetBucketHttpsConfig()
    {
        // miss required field
        try {
            $request = new Models\GetBucketHttpsConfigRequest();
            $input = BucketHttpsConfig::fromGetBucketHttpsConfig($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        $request = new Models\GetBucketHttpsConfigRequest('bucket-123');
        $input = BucketHttpsConfig::fromGetBucketHttpsConfig($request);
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertEquals('1B2M2Y8AsgTpgAmY7PhCfg==', $input->getHeaders()['content-md5']);
    }

    public function testToGetBucketHttpsConfig()
    {
        // empty output
        $output = new OperationOutput();
        $result = BucketHttpsConfig::toGetBucketHttpsConfig($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);
        $this->assertEquals('', $result->requestId);
        $this->assertEquals(0, count($result->headers));

        $body = '<?xml version="1.0" encoding="UTF-8"?>
<HttpsConfiguration>  
  <TLS>
    <Enable>true</Enable>   
    <TLSVersion>TLSv1.2</TLSVersion>
    <TLSVersion>TLSv1.3</TLSVersion>    
  </TLS>
</HttpsConfiguration>';
        $output = new OperationOutput(
            'OK',
            200,
            ['x-oss-request-id' => '123', 'content-type' => 'application/xml'],
            Utils::streamFor($body)
        );
        $result = BucketHttpsConfig::toGetBucketHttpsConfig($output);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
        $this->assertEquals(2, count($result->headers));
        $this->assertEquals('123', $result->headers['x-oss-request-id']);
        $this->assertEquals('application/xml', $result->headers['content-type']);
        $this->assertTrue($result->httpsConfiguration->tls->enable);
        $this->assertEquals(2, count($result->httpsConfiguration->tls->tlsVersions));
        $this->assertEquals("TLSv1.2", $result->httpsConfiguration->tls->tlsVersions[0]);
        $this->assertEquals("TLSv1.3", $result->httpsConfiguration->tls->tlsVersions[1]);
    }

    private function cleanXml($xml): array|string
    {
        return str_replace("\n", "", str_replace("\r", "", $xml));
    }
}
