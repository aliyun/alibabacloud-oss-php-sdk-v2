<?php

namespace UnitTests\Transform;

use AlibabaCloud\Oss\V2\Models;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Transform\BucketObjectFcAccessPoint;
use AlibabaCloud\Oss\V2\Utils;

class BucketObjectFcAccessPointTest extends \PHPUnit\Framework\TestCase
{
    public function testFromCreateAccessPointForObjectProcess()
    {
        // miss required field 
        try {
            $request = new Models\CreateAccessPointForObjectProcessRequest();
            $input = BucketObjectFcAccessPoint::fromCreateAccessPointForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        try {
            $request = new Models\CreateAccessPointForObjectProcessRequest('bucket-123');
            $input = BucketObjectFcAccessPoint::fromCreateAccessPointForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, accessPointForObjectProcessName", (string)$e);
        }

        try {
            $request = new Models\CreateAccessPointForObjectProcessRequest('bucket-123', 'fc-ap-01');
            $input = BucketObjectFcAccessPoint::fromCreateAccessPointForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, createAccessPointForObjectProcessConfiguration", (string)$e);
        }

        $request = new Models\CreateAccessPointForObjectProcessRequest('bucket-123', 'fc-ap-01',
            new Models\CreateAccessPointForObjectProcessConfiguration(
                accessPointName: 'ap-01',
                objectProcessConfiguration: new Models\ObjectProcessConfiguration(
                    allowedFeatures: new Models\AllowedFeatures(['GetObject-Range']),
                    transformationConfigurations: new Models\TransformationConfigurations(
                        [new Models\TransformationConfiguration(
                            actions: new Models\AccessPointActions(['GetObject']),
                            contentTransformation: new Models\ContentTransformation(
                                functionCompute: new Models\FunctionCompute(
                                    functionAssumeRoleArn: 'acs:ram::111933544165****:role/aliyunfcdefaultrole',
                                    functionArn: 'acs:fc:cn-qingdao:111933544165****:services/test-oss-fc.LATEST/functions/fc-01'
                                )
                            )
                        )]
                    )
                )
            ));
        $input = BucketObjectFcAccessPoint::fromCreateAccessPointForObjectProcess($request);
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertEquals('fc-ap-01', $input->getHeaders()['x-oss-access-point-for-object-process-name']);
        $xml = <<<BBB
<?xml version="1.0" encoding="UTF-8"?><CreateAccessPointForObjectProcessConfiguration><AccessPointName>ap-01</AccessPointName><ObjectProcessConfiguration><AllowedFeatures><AllowedFeature>GetObject-Range</AllowedFeature></AllowedFeatures><TransformationConfigurations><TransformationConfiguration><Actions><Action>GetObject</Action></Actions><ContentTransformation><FunctionCompute><FunctionAssumeRoleArn>acs:ram::111933544165****:role/aliyunfcdefaultrole</FunctionAssumeRoleArn><FunctionArn>acs:fc:cn-qingdao:111933544165****:services/test-oss-fc.LATEST/functions/fc-01</FunctionArn></FunctionCompute></ContentTransformation></TransformationConfiguration></TransformationConfigurations></ObjectProcessConfiguration></CreateAccessPointForObjectProcessConfiguration>
BBB;
        $this->assertEquals($xml, $this->cleanXml($input->getBody()->getContents()));
    }

    public function testToCreateAccessPointForObjectProcess()
    {
        // empty output
        $output = new OperationOutput();
        $result = BucketObjectFcAccessPoint::toCreateAccessPointForObjectProcess($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);
        $this->assertEquals('', $result->requestId);
        $this->assertEquals(0, count($result->headers));

        $body = '<?xml version="1.0" encoding="UTF-8"?>
<CreateAccessPointForObjectProcessResult>
  <AccessPointForObjectProcessArn>acs:oss:cn-qingdao:119335441657143:accesspointforobjectprocess/fc-ap-01</AccessPointForObjectProcessArn>
  <AccessPointForObjectProcessAlias>fc-ap-01-3b00521f653d2b3223680ec39dbbe2****-opapalias</AccessPointForObjectProcessAlias>
</CreateAccessPointForObjectProcessResult>';

        $output = new OperationOutput(
            'OK',
            200,
            ['x-oss-request-id' => '123', 'content-type' => 'application/xml'],
            body: Utils::streamFor($body)
        );
        $result = BucketObjectFcAccessPoint::toCreateAccessPointForObjectProcess($output);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
        $this->assertEquals(2, count($result->headers));
        $this->assertEquals('123', $result->headers['x-oss-request-id']);
        $this->assertEquals('application/xml', $result->headers['content-type']);
        $this->assertEquals('acs:oss:cn-qingdao:119335441657143:accesspointforobjectprocess/fc-ap-01', $result->accessPointForObjectProcessArn);
        $this->assertEquals('fc-ap-01-3b00521f653d2b3223680ec39dbbe2****-opapalias', $result->accessPointForObjectProcessAlias);
    }

    public function testFromGetAccessPointForObjectProcess()
    {
        // miss required field
        try {
            $request = new Models\GetAccessPointForObjectProcessRequest();
            $input = BucketObjectFcAccessPoint::fromGetAccessPointForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        try {
            $request = new Models\GetAccessPointForObjectProcessRequest('bucket-123');
            $input = BucketObjectFcAccessPoint::fromGetAccessPointForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, accessPointForObjectProcessName", (string)$e);
        }

        $request = new Models\GetAccessPointForObjectProcessRequest('bucket-123', 'fc-ap-01');
        $input = BucketObjectFcAccessPoint::fromGetAccessPointForObjectProcess($request);
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertEquals('1B2M2Y8AsgTpgAmY7PhCfg==', $input->getHeaders()['content-md5']);
        $this->assertEquals('fc-ap-01', $input->getHeaders()['x-oss-access-point-for-object-process-name']);
    }

    public function testToGetAccessPointForObjectProcess()
    {
        // empty output
        $output = new OperationOutput();
        $result = BucketObjectFcAccessPoint::toGetAccessPointForObjectProcess($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);
        $this->assertEquals('', $result->requestId);
        $this->assertEquals(0, count($result->headers));

        $body = '<?xml version="1.0" encoding="UTF-8"?>
<GetAccessPointForObjectProcessResult>
  <AccessPointNameForObjectProcess>fc-ap-01</AccessPointNameForObjectProcess>
  <AccessPointForObjectProcessAlias>fc-ap-01-3b00521f653d2b3223680ec39dbbe2****-opapalias</AccessPointForObjectProcessAlias>
  <AccessPointName>ap-01</AccessPointName>
  <AccountId>111933544165****</AccountId>
  <AccessPointForObjectProcessArn>acs:oss:cn-qingdao:11933544165****:accesspointforobjectprocess/fc-ap-01</AccessPointForObjectProcessArn>
  <CreationDate>1626769503</CreationDate>
  <Status>enable</Status>
  <Endpoints>
    <PublicEndpoint>fc-ap-01-111933544165****.oss-cn-qingdao.oss-object-process.aliyuncs.com</PublicEndpoint>
    <InternalEndpoint>fc-ap-01-111933544165****.oss-cn-qingdao-internal.oss-object-process.aliyuncs.com</InternalEndpoint>
  </Endpoints>
  <PublicAccessBlockConfiguration>
    <BlockPublicAccess>true</BlockPublicAccess>
  </PublicAccessBlockConfiguration>
</GetAccessPointForObjectProcessResult>';
        $output = new OperationOutput(
            'OK',
            200,
            ['x-oss-request-id' => '123', 'content-type' => 'application/xml'],
            body: Utils::streamFor($body)
        );
        $result = BucketObjectFcAccessPoint::toGetAccessPointForObjectProcess($output);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
        $this->assertEquals(2, count($result->headers));
        $this->assertEquals('123', $result->headers['x-oss-request-id']);
        $this->assertEquals('application/xml', $result->headers['content-type']);
        $this->assertEquals('fc-ap-01', $result->accessPointNameForObjectProcess);
        $this->assertEquals('fc-ap-01-3b00521f653d2b3223680ec39dbbe2****-opapalias', $result->accessPointForObjectProcessAlias);
        $this->assertEquals('ap-01', $result->accessPointName);
        $this->assertEquals('111933544165****', $result->accountId);
        $this->assertEquals('acs:oss:cn-qingdao:11933544165****:accesspointforobjectprocess/fc-ap-01', $result->accessPointForObjectProcessArn);
        $this->assertEquals('1626769503', $result->creationDate);
        $this->assertEquals('enable', $result->accessPointForObjectProcessStatus);
        $this->assertEquals('fc-ap-01-111933544165****.oss-cn-qingdao.oss-object-process.aliyuncs.com', $result->endpoints->publicEndpoint);
        $this->assertEquals('fc-ap-01-111933544165****.oss-cn-qingdao-internal.oss-object-process.aliyuncs.com', $result->endpoints->internalEndpoint);
        $this->assertTrue($result->publicAccessBlockConfiguration->blockPublicAccess);
    }

    public function testFromDeleteAccessPointForObjectProcess()
    {
        // miss required field
        try {
            $request = new Models\DeleteAccessPointForObjectProcessRequest();
            $input = BucketObjectFcAccessPoint::fromDeleteAccessPointForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        try {
            $request = new Models\DeleteAccessPointForObjectProcessRequest('bucket-123');
            $input = BucketObjectFcAccessPoint::fromDeleteAccessPointForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, accessPointForObjectProcessName", (string)$e);
        }

        $request = new Models\DeleteAccessPointForObjectProcessRequest('bucket-123', 'fc-ap-01');
        $input = BucketObjectFcAccessPoint::fromDeleteAccessPointForObjectProcess($request);
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertEquals('1B2M2Y8AsgTpgAmY7PhCfg==', $input->getHeaders()['content-md5']);
        $this->assertEquals('fc-ap-01', $input->getHeaders()['x-oss-access-point-for-object-process-name']);
    }

    public function testToDeleteAccessPointForObjectProcess()
    {
        // empty output
        $output = new OperationOutput();
        $result = BucketObjectFcAccessPoint::toDeleteAccessPointForObjectProcess($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);
        $this->assertEquals('', $result->requestId);
        $this->assertEquals(0, count($result->headers));

        $output = new OperationOutput(
            'No Content',
            204,
            ['x-oss-request-id' => '123'],
        );
        $result = BucketObjectFcAccessPoint::toDeleteAccessPointForObjectProcess($output);
        $this->assertEquals('No Content', $result->status);
        $this->assertEquals(204, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
        $this->assertEquals(1, count($result->headers));
        $this->assertEquals('123', $result->headers['x-oss-request-id']);
    }

    public function testFromListAccessPointForObjectProcess()
    {
        $request = new Models\ListAccessPointsForObjectProcessRequest();
        $input = BucketObjectFcAccessPoint::fromListAccessPointsForObjectProcess($request);
        $this->assertEquals('1B2M2Y8AsgTpgAmY7PhCfg==', $input->getHeaders()['content-md5']);

        $request = new Models\ListAccessPointsForObjectProcessRequest(10, 'token');
        $input = BucketObjectFcAccessPoint::fromListAccessPointsForObjectProcess($request);
        $this->assertEquals('1B2M2Y8AsgTpgAmY7PhCfg==', $input->getHeaders()['content-md5']);
        $this->assertEquals('10', $input->getParameters()['max-keys']);
        $this->assertEquals('token', $input->getParameters()['continuation-token']);
    }

    public function testToListAccessPointForObjectProcess()
    {
        // empty output
        $output = new OperationOutput();
        $result = BucketObjectFcAccessPoint::toListAccessPointsForObjectProcess($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);
        $this->assertEquals('', $result->requestId);
        $this->assertEquals(0, count($result->headers));

        $body = '<?xml version="1.0" encoding="UTF-8"?>
<ListAccessPointsForObjectProcessResult>
   <IsTruncated>true</IsTruncated>
   <NextContinuationToken>abc</NextContinuationToken>
   <AccountId>111933544165****</AccountId>
   <AccessPointsForObjectProcess>
      <AccessPointForObjectProcess>
          <AccessPointNameForObjectProcess>fc-ap-01</AccessPointNameForObjectProcess>
          <AccessPointForObjectProcessAlias>fc-ap-01-3b00521f653d2b3223680ec39dbbe2****-opapalias</AccessPointForObjectProcessAlias>
          <AccessPointName>fc-01</AccessPointName>
          <Status>enable</Status>
      </AccessPointForObjectProcess>
   </AccessPointsForObjectProcess>
</ListAccessPointsForObjectProcessResult>';
        $output = new OperationOutput(
            'OK',
            200,
            ['x-oss-request-id' => '123', 'content-type' => 'application/xml'],
            body: Utils::streamFor($body)
        );
        $result = BucketObjectFcAccessPoint::toListAccessPointsForObjectProcess($output);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
        $this->assertEquals(2, count($result->headers));
        $this->assertEquals('123', $result->headers['x-oss-request-id']);
        $this->assertEquals('application/xml', $result->headers['content-type']);
        $this->assertEquals(1, count($result->accessPointsForObjectProcess->accessPointForObjectProcesss));
        $this->assertEquals('fc-ap-01', $result->accessPointsForObjectProcess->accessPointForObjectProcesss[0]->accessPointNameForObjectProcess);
        $this->assertEquals('fc-ap-01-3b00521f653d2b3223680ec39dbbe2****-opapalias', $result->accessPointsForObjectProcess->accessPointForObjectProcesss[0]->accessPointForObjectProcessAlias);
        $this->assertEquals('fc-01', $result->accessPointsForObjectProcess->accessPointForObjectProcesss[0]->accessPointName);
        $this->assertEquals('enable', $result->accessPointsForObjectProcess->accessPointForObjectProcesss[0]->status);
    }

    public function testFromPutAccessPointPolicyForObjectProcess()
    {
        // miss required field
        try {
            $request = new Models\PutAccessPointPolicyForObjectProcessRequest();
            $input = BucketObjectFcAccessPoint::fromPutAccessPointPolicyForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        try {
            $request = new Models\PutAccessPointPolicyForObjectProcessRequest('bucket-123');
            $input = BucketObjectFcAccessPoint::fromPutAccessPointPolicyForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, accessPointForObjectProcessName", (string)$e);
        }

        try {
            $request = new Models\PutAccessPointPolicyForObjectProcessRequest('bucket-123', 'ap-01');
            $input = BucketObjectFcAccessPoint::fromPutAccessPointPolicyForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, body", (string)$e);
        }

        $request = new Models\PutAccessPointPolicyForObjectProcessRequest('bucket-123', 'ap-01', '{"Version":"1","Statement":[{"Effect":"Allow","Action":["oss:GetObject"],"Principal":["23721626365841xxxx"],"Resource":["acs:oss:cn-qingdao:111933544165xxxx:accesspointforobjectprocess/fc-ap-01/object/*"]}]}');
        $input = BucketObjectFcAccessPoint::fromPutAccessPointPolicyForObjectProcess($request);
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertEquals('{"Version":"1","Statement":[{"Effect":"Allow","Action":["oss:GetObject"],"Principal":["23721626365841xxxx"],"Resource":["acs:oss:cn-qingdao:111933544165xxxx:accesspointforobjectprocess/fc-ap-01/object/*"]}]}', $input->getBody()->getContents());
    }

    public function testToPutAccessPointPolicyForObjectProcess()
    {
        // empty output
        $output = new OperationOutput();
        $result = BucketObjectFcAccessPoint::toPutAccessPointPolicyForObjectProcess($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);
        $this->assertEquals('', $result->requestId);
        $this->assertEquals(0, count($result->headers));

        $output = new OperationOutput(
            'OK',
            200,
            ['x-oss-request-id' => '123'],
        );
        $result = BucketObjectFcAccessPoint::toPutAccessPointPolicyForObjectProcess($output);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
        $this->assertEquals(1, count($result->headers));
        $this->assertEquals('123', $result->headers['x-oss-request-id']);
    }

    public function testFromGetAccessPointPolicyForObjectProcess()
    {
        // miss required field
        try {
            $request = new Models\GetAccessPointPolicyForObjectProcessRequest();
            $input = BucketObjectFcAccessPoint::fromGetAccessPointPolicyForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        try {
            $request = new Models\GetAccessPointPolicyForObjectProcessRequest('bucket-123');
            $input = BucketObjectFcAccessPoint::fromGetAccessPointPolicyForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, accessPointForObjectProcessName", (string)$e);
        }

        $request = new Models\GetAccessPointPolicyForObjectProcessRequest('bucket-123', 'ap-01');
        $input = BucketObjectFcAccessPoint::fromGetAccessPointPolicyForObjectProcess($request);
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertEquals('ap-01', $input->getHeaders()['x-oss-access-point-for-object-process-name']);
    }

    public function testToGetAccessPointPolicyForObjectProcess()
    {
        // empty output
        $output = new OperationOutput();
        $result = BucketObjectFcAccessPoint::toGetAccessPointPolicyForObjectProcess($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);
        $this->assertEquals('', $result->requestId);
        $this->assertEquals(0, count($result->headers));

        $body = '{
   "Version":"1",
   "Statement":[
   {
     "Action":[
       "oss:PutObject",
       "oss:GetObject"
    ],
    "Effect":"Deny",
    "Principal":["27737962156157xxxx"],
    "Resource":[
       "acs:oss:cn-hangzhou:111933544165xxxx:accesspoint/$ap-01",
       "acs:oss:cn-hangzhou:111933544165xxxx:accesspoint/$ap-01/object/*"
     ]
   }
  ]
 }';
        $output = new OperationOutput(
            'OK',
            200,
            ['x-oss-request-id' => '123', 'content-type' => 'application/json'],
            body: Utils::streamFor($body)
        );
        $result = BucketObjectFcAccessPoint::toGetAccessPointPolicyForObjectProcess($output);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
        $this->assertEquals(2, count($result->headers));
        $this->assertEquals('123', $result->headers['x-oss-request-id']);
        $this->assertEquals('application/json', $result->headers['content-type']);
        $this->assertEquals($body, $result->body);
    }

    public function testFromDeleteAccessPointPolicyForObjectProcess()
    {
        // miss required field
        try {
            $request = new Models\DeleteAccessPointPolicyForObjectProcessRequest();
            $input = BucketObjectFcAccessPoint::fromDeleteAccessPointPolicyForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        try {
            $request = new Models\DeleteAccessPointPolicyForObjectProcessRequest('bucket-123');
            $input = BucketObjectFcAccessPoint::fromDeleteAccessPointPolicyForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, accessPointForObjectProcessName", (string)$e);
        }

        $request = new Models\DeleteAccessPointPolicyForObjectProcessRequest('bucket-123', 'ap-01');
        $input = BucketObjectFcAccessPoint::fromDeleteAccessPointPolicyForObjectProcess($request);
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertEquals('1B2M2Y8AsgTpgAmY7PhCfg==', $input->getHeaders()['content-md5']);
        $this->assertEquals('ap-01', $input->getHeaders()['x-oss-access-point-for-object-process-name']);
    }

    public function testToDeleteAccessPointPolicyForObjectProcess()
    {
        // empty output
        $output = new OperationOutput();
        $result = BucketObjectFcAccessPoint::toDeleteAccessPointPolicyForObjectProcess($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);
        $this->assertEquals('', $result->requestId);
        $this->assertEquals(0, count($result->headers));

        $output = new OperationOutput(
            'No Content',
            204,
            ['x-oss-request-id' => '123'],
        );
        $result = BucketObjectFcAccessPoint::toDeleteAccessPointPolicyForObjectProcess($output);
        $this->assertEquals('No Content', $result->status);
        $this->assertEquals(204, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
        $this->assertEquals(1, count($result->headers));
        $this->assertEquals('123', $result->headers['x-oss-request-id']);
    }

    public function testFromPutAccessPointConfigForObjectProcess()
    {
        // miss required field
        try {
            $request = new Models\PutAccessPointConfigForObjectProcessRequest();
            $input = BucketObjectFcAccessPoint::fromPutAccessPointConfigForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        try {
            $request = new Models\PutAccessPointConfigForObjectProcessRequest('bucket-123');
            $input = BucketObjectFcAccessPoint::fromPutAccessPointConfigForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, accessPointForObjectProcessName", (string)$e);
        }

        try {
            $request = new Models\PutAccessPointConfigForObjectProcessRequest('bucket-123', 'ap-01');
            $input = BucketObjectFcAccessPoint::fromPutAccessPointConfigForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, putAccessPointConfigForObjectProcessConfiguration", (string)$e);
        }

        $request = new Models\PutAccessPointConfigForObjectProcessRequest('bucket-123', 'ap-01', putAccessPointConfigForObjectProcessConfiguration: new Models\PutAccessPointConfigForObjectProcessConfiguration(
            publicAccessBlockConfiguration: new Models\PublicAccessBlockConfiguration(
            blockPublicAccess: true,
        ), objectProcessConfiguration: new Models\ObjectProcessConfiguration(
                allowedFeatures: new Models\AllowedFeatures(['GetObject-Range']),
                transformationConfigurations: new Models\TransformationConfigurations(
                    [new Models\TransformationConfiguration(
                        actions: new Models\AccessPointActions(['GetObject']),
                        contentTransformation: new Models\ContentTransformation(
                            functionCompute: new Models\FunctionCompute(
                                functionAssumeRoleArn: 'acs:fc:cn-qingdao:111933544165****:services/test-oss-fc.LATEST/functions/fc-01',
                                functionArn: 'acs:ram::111933544165****:role/aliyunfcdefaultrole'
                            )
                        )
                    )]
                )
            )
        ));
        $xml = <<<BBB
<?xml version="1.0" encoding="UTF-8"?><PutAccessPointConfigForObjectProcessConfiguration><PublicAccessBlockConfiguration><BlockPublicAccess>true</BlockPublicAccess></PublicAccessBlockConfiguration><ObjectProcessConfiguration><AllowedFeatures><AllowedFeature>GetObject-Range</AllowedFeature></AllowedFeatures><TransformationConfigurations><TransformationConfiguration><Actions><Action>GetObject</Action></Actions><ContentTransformation><FunctionCompute><FunctionAssumeRoleArn>acs:fc:cn-qingdao:111933544165****:services/test-oss-fc.LATEST/functions/fc-01</FunctionAssumeRoleArn><FunctionArn>acs:ram::111933544165****:role/aliyunfcdefaultrole</FunctionArn></FunctionCompute></ContentTransformation></TransformationConfiguration></TransformationConfigurations></ObjectProcessConfiguration></PutAccessPointConfigForObjectProcessConfiguration>
BBB;

        $input = BucketObjectFcAccessPoint::fromPutAccessPointConfigForObjectProcess($request);
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertEquals('ap-01', $input->getHeaders()['x-oss-access-point-for-object-process-name']);
        $this->assertEquals($xml, $this->cleanXml($input->getBody()->getContents()));
    }

    public function testToPutAccessPointConfigForObjectProcess()
    {
        // empty output
        $output = new OperationOutput();
        $result = BucketObjectFcAccessPoint::toPutAccessPointConfigForObjectProcess($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);
        $this->assertEquals('', $result->requestId);
        $this->assertEquals(0, count($result->headers));

        $output = new OperationOutput(
            'OK',
            200,
            ['x-oss-request-id' => '123', 'content-type' => 'application/xml'],
        );
        $result = BucketObjectFcAccessPoint::toPutAccessPointConfigForObjectProcess($output);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
        $this->assertEquals(2, count($result->headers));
        $this->assertEquals('123', $result->headers['x-oss-request-id']);
        $this->assertEquals('application/xml', $result->headers['content-type']);
    }

    public function testFromGetAccessPointConfigForObjectProcess()
    {
        // miss required field
        try {
            $request = new Models\GetAccessPointConfigForObjectProcessRequest();
            $input = BucketObjectFcAccessPoint::fromGetAccessPointConfigForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, bucket", (string)$e);
        }

        try {
            $request = new Models\GetAccessPointConfigForObjectProcessRequest('bucket-123');
            $input = BucketObjectFcAccessPoint::fromGetAccessPointConfigForObjectProcess($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, accessPointForObjectProcessName", (string)$e);
        }

        $request = new Models\GetAccessPointConfigForObjectProcessRequest('bucket-123', 'ap-01');
        $input = BucketObjectFcAccessPoint::fromGetAccessPointConfigForObjectProcess($request);
        $this->assertEquals('bucket-123', $input->getBucket());
        $this->assertEquals('ap-01', $input->getHeaders()['x-oss-access-point-for-object-process-name']);
    }

    public function testToGetAccessPointConfigForObjectProcess()
    {
        // empty output
        $output = new OperationOutput();
        $result = BucketObjectFcAccessPoint::toGetAccessPointConfigForObjectProcess($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);
        $this->assertEquals('', $result->requestId);
        $this->assertEquals(0, count($result->headers));

        $body = '<?xml version="1.0" encoding="UTF-8"?>
<GetAccessPointConfigForObjectProcessResult>
  <ObjectProcessConfiguration>
    <AllowedFeatures/>
    <TransformationConfigurations>
      <TransformationConfiguration>
        <Actions>
          <Action>getobject</Action>
        </Actions>
        <ContentTransformation>
          <FunctionCompute>
            <FunctionAssumeRoleArn>acs:ram::111933544165****:role/aliyunfcdefaultrole</FunctionAssumeRoleArn>
            <FunctionArn>acs:fc:cn-qingdao:111933544165****:services/test-oss-fc.LATEST/functions/fc-01</FunctionArn>
          </FunctionCompute>
        </ContentTransformation>
      </TransformationConfiguration>
    </TransformationConfigurations>
  </ObjectProcessConfiguration>
  <PublicAccessBlockConfiguration>
    <BlockPublicAccess>true</BlockPublicAccess>
  </PublicAccessBlockConfiguration> 
</GetAccessPointConfigForObjectProcessResult>';
        $output = new OperationOutput(
            'OK',
            200,
            ['x-oss-request-id' => '123', 'content-type' => 'application/xml'],
            body: Utils::streamFor($body)
        );
        $result = BucketObjectFcAccessPoint::toGetAccessPointConfigForObjectProcess($output);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
        $this->assertEquals(2, count($result->headers));
        $this->assertEquals('123', $result->headers['x-oss-request-id']);
        $this->assertEquals('application/xml', $result->headers['content-type']);
        $this->assertTrue($result->publicAccessBlockConfiguration->blockPublicAccess);
        $this->assertEquals('getobject', $result->objectProcessConfiguration->transformationConfigurations->transformationConfigurations[0]->actions->actions[0]);
        $this->assertEquals('acs:ram::111933544165****:role/aliyunfcdefaultrole', $result->objectProcessConfiguration->transformationConfigurations->transformationConfigurations[0]->contentTransformation->functionCompute->functionAssumeRoleArn);
        $this->assertEquals('acs:fc:cn-qingdao:111933544165****:services/test-oss-fc.LATEST/functions/fc-01', $result->objectProcessConfiguration->transformationConfigurations->transformationConfigurations[0]->contentTransformation->functionCompute->functionArn);
    }

    public function testFromWriteGetObjectResponse()
    {
        // miss required field
        try {
            $request = new Models\WriteGetObjectResponseRequest();
            $input = BucketObjectFcAccessPoint::fromWriteGetObjectResponse($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, requestRoute", (string)$e);
        }

        try {
            $request = new Models\WriteGetObjectResponseRequest('fc-ap-01-176022554508***-opap.oss-cn-hangzhou.oss-object-process.aliyuncs.com');
            $input = BucketObjectFcAccessPoint::fromWriteGetObjectResponse($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, requestToken", (string)$e);
        }

        try {
            $request = new Models\WriteGetObjectResponseRequest('fc-ap-01-176022554508***-opap.oss-cn-hangzhou.oss-object-process.aliyuncs.com', 'token');
            $input = BucketObjectFcAccessPoint::fromWriteGetObjectResponse($request);
            $this->assertTrue(false, "should not here");
        } catch (\InvalidArgumentException $e) {
            $this->assertStringContainsString("missing required field, fwdStatus", (string)$e);
        }


        $request = new Models\WriteGetObjectResponseRequest('fc-ap-01-176022554508***-opap.oss-cn-hangzhou.oss-object-process.aliyuncs.com', 'token', '200');
        $input = BucketObjectFcAccessPoint::fromWriteGetObjectResponse($request);
        $this->assertEquals('fc-ap-01-176022554508***-opap.oss-cn-hangzhou.oss-object-process.aliyuncs.com', $input->getHeaders()['x-oss-request-route']);
        $this->assertEquals('token', $input->getHeaders()['x-oss-request-token']);
        $this->assertEquals('200', $input->getHeaders()['x-oss-fwd-status']);
    }

    public function testToWriteGetObjectResponse()
    {
        // empty output
        $output = new OperationOutput();
        $result = BucketObjectFcAccessPoint::toGetAccessPointConfigForObjectProcess($output);
        $this->assertEquals('', $result->status);
        $this->assertEquals(0, $result->statusCode);
        $this->assertEquals('', $result->requestId);
        $this->assertEquals(0, count($result->headers));

        $output = new OperationOutput(
            'OK',
            200,
            ['x-oss-request-id' => '123', 'content-type' => 'application/xml'],
        );
        $result = BucketObjectFcAccessPoint::toGetAccessPointConfigForObjectProcess($output);
        $this->assertEquals('OK', $result->status);
        $this->assertEquals(200, $result->statusCode);
        $this->assertEquals('123', $result->requestId);
        $this->assertEquals(2, count($result->headers));
        $this->assertEquals('123', $result->headers['x-oss-request-id']);
        $this->assertEquals('application/xml', $result->headers['content-type']);
    }

    private function cleanXml($xml): array|string
    {
        return str_replace("\n", "", str_replace("\r", "", $xml));
    }
}
