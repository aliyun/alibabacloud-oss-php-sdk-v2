<?php

namespace IntegrationTests;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'TestIntegration.php';

use AlibabaCloud\Oss\V2 as Oss;

class ClientAccessPointForObjectProcessTest extends TestIntegration
{
    public function testAccessPointForObjectProcess()
    {
        $client = $this->getDefaultClient();
        $bucketName = self::$bucketName;

        $accessPointName = 'ap-01-' . strval(rand(0, 100)) . '-' . strval(time());
        $createResult = $client->createAccessPoint(new Oss\Models\CreateAccessPointRequest(
            $bucketName,
            new Oss\Models\CreateAccessPointConfiguration(
                accessPointName: $accessPointName,
                networkOrigin: 'internet',
            )));
        $this->assertEquals(200, $createResult->statusCode);
        $this->assertEquals('OK', $createResult->status);
        $this->assertEquals(True, count($createResult->headers) > 0);
        $this->assertEquals(24, strlen($createResult->requestId));

        $objectProcessName = 'fc-ap-01-' . strval(rand(0, 100)) . '-' . strval(time());
        $arn = "acs:fc:" . self::$REGION . ":" . self::$USER_ID . ":services/test-oss-fc.LATEST/functions/" . $objectProcessName;
        $roleArn = "acs:ram::" . self::$USER_ID . ":role/aliyunfcdefaultrole";

        // CreateAccessPointForObjectProcess
        $createResult = $client->createAccessPointForObjectProcess(new Oss\Models\CreateAccessPointForObjectProcessRequest(
            bucket: $bucketName,
            accessPointForObjectProcessName: $objectProcessName,
            createAccessPointForObjectProcessConfiguration: new Oss\Models\CreateAccessPointForObjectProcessConfiguration(
                accessPointName: $accessPointName,
                objectProcessConfiguration: new Oss\Models\ObjectProcessConfiguration(
                    allowedFeatures: new Oss\Models\AllowedFeatures(['GetObject-Range']),
                    transformationConfigurations: new Oss\Models\TransformationConfigurations(
                        [new Oss\Models\TransformationConfiguration(
                            actions: new Oss\Models\AccessPointActions(['GetObject']),
                            contentTransformation: new Oss\Models\ContentTransformation(
                                functionCompute: new Oss\Models\FunctionCompute(
                                    functionAssumeRoleArn: $roleArn,
                                    functionArn: $arn,
                                )
                            )
                        )]
                    )
                )
            )
        ));
        $this->assertEquals(200, $createResult->statusCode);
        $this->assertEquals('OK', $createResult->status);
        $this->assertEquals(True, count($createResult->headers) > 0);
        $this->assertEquals(24, strlen($createResult->requestId));

        // GetAccessPointForObjectProcess
        $getResult = $client->getAccessPointForObjectProcess(new Oss\Models\GetAccessPointForObjectProcessRequest(
            bucket: $bucketName,
            accessPointForObjectProcessName: $objectProcessName
        ));
        $this->assertEquals(200, $getResult->statusCode);
        $this->assertEquals('OK', $getResult->status);
        $this->assertEquals(True, count($getResult->headers) > 0);
        $this->assertEquals(24, strlen($getResult->requestId));

        // ListAccessPointsForObjectProcess
        $listResult = $client->listAccessPointsForObjectProcess(new Oss\Models\ListAccessPointsForObjectProcessRequest());
        $this->assertEquals(200, $listResult->statusCode);
        $this->assertEquals('OK', $listResult->status);
        $this->assertEquals(True, count($listResult->headers) > 0);
        $this->assertEquals(24, strlen($listResult->requestId));

        // PutAccessPointPolicyForObjectProcess
        $policy = '{"Version":"1","Statement":[{"Action":["oss:GetObject"],"Effect":"Allow","Principal":["' . self::$USER_ID . '"],"Resource":["acs:oss:' . self::$REGION . ':' . self::$USER_ID . ':accesspointforobjectprocess/' . $objectProcessName . '/object/*"]}]}';
        $putPolicyResult = $client->putAccessPointPolicyForObjectProcess(new Oss\Models\PutAccessPointPolicyForObjectProcessRequest(
            bucket: $bucketName,
            accessPointForObjectProcessName: $objectProcessName,
            body: Oss\Utils::streamFor($policy)
        ));
        $this->assertEquals(200, $putPolicyResult->statusCode);
        $this->assertEquals('OK', $putPolicyResult->status);
        $this->assertEquals(True, count($putPolicyResult->headers) > 0);
        $this->assertEquals(24, strlen($putPolicyResult->requestId));

        // GetAccessPointPolicyForObjectProcess
        $getPolicyResult = $client->getAccessPointPolicyForObjectProcess(new Oss\Models\GetAccessPointPolicyForObjectProcessRequest(
            bucket: $bucketName,
            accessPointForObjectProcessName: $objectProcessName,
        ));
        $this->assertEquals(200, $getPolicyResult->statusCode);
        $this->assertEquals('OK', $getPolicyResult->status);
        $this->assertEquals(True, count($getPolicyResult->headers) > 0);
        $this->assertEquals(24, strlen($getPolicyResult->requestId));
        $this->assertEquals($policy, $getPolicyResult->body);

        // DeleteAccessPointPolicyForObjectProcess
        $delPolicyResult = $client->deleteAccessPointPolicyForObjectProcess(new Oss\Models\DeleteAccessPointPolicyForObjectProcessRequest(
            bucket: $bucketName,
            accessPointForObjectProcessName: $objectProcessName,
        ));
        $this->assertEquals(204, $delPolicyResult->statusCode);
        $this->assertEquals('No Content', $delPolicyResult->status);
        $this->assertEquals(True, count($delPolicyResult->headers) > 0);
        $this->assertEquals(24, strlen($delPolicyResult->requestId));

        // PutAccessPointConfigForObjectProcess
        $putConfigResult = $client->putAccessPointConfigForObjectProcess(new Oss\Models\PutAccessPointConfigForObjectProcessRequest(
            bucket: $bucketName,
            accessPointForObjectProcessName: $objectProcessName,
            putAccessPointConfigForObjectProcessConfiguration: new Oss\Models\PutAccessPointConfigForObjectProcessConfiguration(
                publicAccessBlockConfiguration: new Oss\Models\PublicAccessBlockConfiguration(
                blockPublicAccess: true
            ),
                objectProcessConfiguration: new Oss\Models\ObjectProcessConfiguration(
                    allowedFeatures: new Oss\Models\AllowedFeatures(['GetObject-Range']),
                    transformationConfigurations: new Oss\Models\TransformationConfigurations(
                        [
                            new Oss\Models\TransformationConfiguration(
                                actions: new Oss\Models\AccessPointActions(['GetObject']),
                                contentTransformation: new Oss\Models\ContentTransformation(
                                    functionCompute: new Oss\Models\FunctionCompute(
                                        functionAssumeRoleArn: $roleArn,
                                        functionArn: $arn
                                    )
                                )
                            )
                        ]
                    )
                )
            )
        ));
        $this->assertEquals(200, $putConfigResult->statusCode);
        $this->assertEquals('OK', $putConfigResult->status);
        $this->assertEquals(True, count($putConfigResult->headers) > 0);
        $this->assertEquals(24, strlen($putConfigResult->requestId));

        // GetAccessPointConfigForObjectProcess
        $getConfigResult = $client->getAccessPointConfigForObjectProcess(new Oss\Models\GetAccessPointConfigForObjectProcessRequest(
            bucket: $bucketName,
            accessPointForObjectProcessName: $objectProcessName,
        ));
        $this->assertEquals(200, $getConfigResult->statusCode);
        $this->assertEquals('OK', $getConfigResult->status);
        $this->assertEquals(True, count($getConfigResult->headers) > 0);
        $this->assertEquals(24, strlen($getConfigResult->requestId));

        while (true) {
            $getResult = $client->getAccessPointForObjectProcess(new Oss\Models\GetAccessPointForObjectProcessRequest(
                $bucketName, $objectProcessName
            ));
            if ($getResult->accessPointForObjectProcessStatus != 'creating') {
                break;
            } else {
                sleep(3);
            }
        }

        $delFcResult = $client->deleteAccessPointForObjectProcess(new Oss\Models\DeleteAccessPointForObjectProcessRequest(
            bucket: $bucketName,
            accessPointForObjectProcessName: $objectProcessName,
        ));
        $this->assertEquals(204, $delFcResult->statusCode);
        $this->assertEquals('No Content', $delFcResult->status);
        $this->assertEquals(True, count($delFcResult->headers) > 0);
        $this->assertEquals(24, strlen($delFcResult->requestId));

        while (true) {
            try {
                $client->getAccessPointForObjectProcess(new Oss\Models\GetAccessPointForObjectProcessRequest(
                    $bucketName, $objectProcessName
                ));
            } catch (Oss\Exception\OperationException $e) {
                $se = $e->getPrevious();
                if ($se instanceof Oss\Exception\ServiceException) {
                    if ($se->getErrorCode() == 'NoSuchAccessPointForObjectProcess' && $se->getStatusCode() == 404) {
                        break;
                    }
                }
            }
            sleep(3);
        }

        while (true) {
            $getResult = $client->getAccessPoint(new Oss\Models\GetAccessPointRequest(
                $bucketName, $accessPointName
            ));
            if ($getResult->getAccessPoint->status != 'creating') {
                break;
            } else {
                sleep(3);
            }
        }
        $delResult = $client->deleteAccessPoint(new Oss\Models\DeleteAccessPointRequest(
            bucket: $bucketName,
            accessPointName: $accessPointName,
        ));
        $this->assertEquals(204, $delResult->statusCode);
        $this->assertEquals('No Content', $delResult->status);
        $this->assertEquals(True, count($delResult->headers) > 0);
        $this->assertEquals(24, strlen($delResult->requestId));
    }

    public function testAccessPointForObjectProcessFail()
    {
        $client = $this->getDefaultClient();
        $accessPointName = 'ap-01-' . strval(rand(0, 100)) . '-' . strval(time());
        $bucketName = self::$bucketName . "-not-exist";
        $objectProcessName = 'fc-ap-01-' . strval(rand(0, 100)) . '-' . strval(time());
        $arn = "acs:fc:" . self::$REGION . ":" . self::$USER_ID . ":services/test-oss-fc.LATEST/functions/" . $objectProcessName;
        $roleArn = "acs:ram::" . self::$USER_ID . ":role/aliyunfcdefaultrole";
        // CreateAccessPointForObjectProcess
        try {
            $client->createAccessPointForObjectProcess(new Oss\Models\CreateAccessPointForObjectProcessRequest(
                bucket: $bucketName,
                accessPointForObjectProcessName: $objectProcessName,
                createAccessPointForObjectProcessConfiguration: new Oss\Models\CreateAccessPointForObjectProcessConfiguration(
                    accessPointName: $accessPointName,
                    objectProcessConfiguration: new Oss\Models\ObjectProcessConfiguration(
                        allowedFeatures: new Oss\Models\AllowedFeatures(['GetObject-Range']),
                        transformationConfigurations: new Oss\Models\TransformationConfigurations(
                            [new Oss\Models\TransformationConfiguration(
                                actions: new Oss\Models\AccessPointActions(['GetObject']),
                                contentTransformation: new Oss\Models\ContentTransformation(
                                    functionCompute: new Oss\Models\FunctionCompute(
                                        functionAssumeRoleArn: $roleArn,
                                        functionArn: $arn,
                                    )
                                )
                            )]
                        )
                    )
                )
            ));
            $this->assertTrue(false, "should not here");
        } catch (Oss\Exception\OperationException $e) {
            $this->assertStringContainsString('Operation error CreateAccessPoint', $e);
            $se = $e->getPrevious();
            $this->assertInstanceOf(Oss\Exception\ServiceException::class, $se);
            if ($se instanceof Oss\Exception\ServiceException) {
                $this->assertEquals('NoSuchBucket', $se->getErrorCode());
                $this->assertEquals(404, $se->getStatusCode());
                $this->assertEquals(24, strlen($se->getRequestId()));
            }
        }

        // GetAccessPointForObjectProcess
        try {
            $client->getAccessPointForObjectProcess(new Oss\Models\GetAccessPointForObjectProcessRequest(
                bucket: $bucketName,
                accessPointForObjectProcessName: $objectProcessName
            ));
            $this->assertTrue(false, "should not here");
        } catch (Oss\Exception\OperationException $e) {
            $this->assertStringContainsString('Operation error GetAccessPointForObjectProcess', $e);
            $se = $e->getPrevious();
            $this->assertInstanceOf(Oss\Exception\ServiceException::class, $se);
            if ($se instanceof Oss\Exception\ServiceException) {
                $this->assertEquals('NoSuchBucket', $se->getErrorCode());
                $this->assertEquals(404, $se->getStatusCode());
                $this->assertEquals(24, strlen($se->getRequestId()));
            }
        }

        // ListAccessPointsForObjectProcess
        try {
            $invalidClient = $this->getInvalidAkClient();
            $listResult = $invalidClient->listAccessPointsForObjectProcess(new Oss\Models\ListAccessPointsForObjectProcessRequest());
            $this->assertTrue(false, "should not here");
        } catch (Oss\Exception\OperationException $e) {
            $this->assertStringContainsString('Operation error ListAccessPointsForObjectProcess', $e);
            $se = $e->getPrevious();
            $this->assertInstanceOf(Oss\Exception\ServiceException::class, $se);
            if ($se instanceof Oss\Exception\ServiceException) {
                $this->assertEquals('InvalidAccessKeyId', $se->getErrorCode());
                $this->assertEquals(403, $se->getStatusCode());
                $this->assertEquals(24, strlen($se->getRequestId()));
            }
        }

        // PutAccessPointPolicyForObjectProcess
        try {
            $policy = '{"Version":"1","Statement":[{"Action":["oss:GetObject"],"Effect":"Allow","Principal":["' . self::$USER_ID . '"],"Resource":["acs:oss:' . self::$REGION . ':' . self::$USER_ID . ':accesspointforobjectprocess/' . $objectProcessName . '/object/*"]}]}';
            $putPolicyResult = $client->putAccessPointPolicyForObjectProcess(new Oss\Models\PutAccessPointPolicyForObjectProcessRequest(
                bucket: $bucketName,
                accessPointForObjectProcessName: $objectProcessName,
                body: Oss\Utils::streamFor($policy)
            ));
            $this->assertTrue(false, "should not here");
        } catch (Oss\Exception\OperationException $e) {
            $this->assertStringContainsString('Operation error PutAccessPointPolicyForObjectProcess', $e);
            $se = $e->getPrevious();
            $this->assertInstanceOf(Oss\Exception\ServiceException::class, $se);
            if ($se instanceof Oss\Exception\ServiceException) {
                $this->assertEquals('NoSuchBucket', $se->getErrorCode());
                $this->assertEquals(404, $se->getStatusCode());
                $this->assertEquals(24, strlen($se->getRequestId()));
            }
        }

        // GetAccessPointPolicy
        try {
            $getPolicyResult = $client->getAccessPointPolicyForObjectProcess(new Oss\Models\GetAccessPointPolicyForObjectProcessRequest(
                bucket: $bucketName,
                accessPointForObjectProcessName: $objectProcessName,
            ));
            $this->assertTrue(false, "should not here");
        } catch (Oss\Exception\OperationException $e) {
            $this->assertStringContainsString('Operation error GetAccessPointPolicy', $e);
            $se = $e->getPrevious();
            $this->assertInstanceOf(Oss\Exception\ServiceException::class, $se);
            if ($se instanceof Oss\Exception\ServiceException) {
                $this->assertEquals('NoSuchBucket', $se->getErrorCode());
                $this->assertEquals(404, $se->getStatusCode());
                $this->assertEquals(24, strlen($se->getRequestId()));
            }
        }

        // DeleteAccessPointPolicyForObjectProcess
        try {
            $delPolicyResult = $client->deleteAccessPointPolicyForObjectProcess(new Oss\Models\DeleteAccessPointPolicyForObjectProcessRequest(
                bucket: $bucketName,
                accessPointForObjectProcessName: $objectProcessName,
            ));
            $this->assertTrue(false, "should not here");
        } catch (Oss\Exception\OperationException $e) {
            $this->assertStringContainsString('Operation error DeleteAccessPointPolicyForObjectProcess', $e);
            $se = $e->getPrevious();
            $this->assertInstanceOf(Oss\Exception\ServiceException::class, $se);
            if ($se instanceof Oss\Exception\ServiceException) {
                $this->assertEquals('NoSuchBucket', $se->getErrorCode());
                $this->assertEquals(404, $se->getStatusCode());
                $this->assertEquals(24, strlen($se->getRequestId()));
            }
        }

        // PutAccessPointConfigForObjectProcess
        try {
            $putConfigResult = $client->putAccessPointConfigForObjectProcess(new Oss\Models\PutAccessPointConfigForObjectProcessRequest(
                bucket: $bucketName,
                accessPointForObjectProcessName: $objectProcessName,
                putAccessPointConfigForObjectProcessConfiguration: new Oss\Models\PutAccessPointConfigForObjectProcessConfiguration(
                    publicAccessBlockConfiguration: new Oss\Models\PublicAccessBlockConfiguration(
                    blockPublicAccess: true
                ),
                    objectProcessConfiguration: new Oss\Models\ObjectProcessConfiguration(
                        allowedFeatures: new Oss\Models\AllowedFeatures(['GetObject-Range']),
                        transformationConfigurations: new Oss\Models\TransformationConfigurations(
                            [
                                new Oss\Models\TransformationConfiguration(
                                    actions: new Oss\Models\AccessPointActions(['GetObject']),
                                    contentTransformation: new Oss\Models\ContentTransformation(
                                        functionCompute: new Oss\Models\FunctionCompute(
                                            functionAssumeRoleArn: $roleArn,
                                            functionArn: $arn
                                        )
                                    )
                                )
                            ]
                        )
                    )
                )
            ));
            $this->assertTrue(false, "should not here");
        } catch (Oss\Exception\OperationException $e) {
            $this->assertStringContainsString('Operation error PutAccessPointConfigForObjectProcess', $e);
            $se = $e->getPrevious();
            $this->assertInstanceOf(Oss\Exception\ServiceException::class, $se);
            if ($se instanceof Oss\Exception\ServiceException) {
                $this->assertEquals('NoSuchBucket', $se->getErrorCode());
                $this->assertEquals(404, $se->getStatusCode());
                $this->assertEquals(24, strlen($se->getRequestId()));
            }
        }

        // GetAccessPointConfigForObjectProcess
        try {
            $getConfigResult = $client->getAccessPointConfigForObjectProcess(new Oss\Models\GetAccessPointConfigForObjectProcessRequest(
                bucket: $bucketName,
                accessPointForObjectProcessName: $objectProcessName,
            ));
            $this->assertTrue(false, "should not here");
        } catch (Oss\Exception\OperationException $e) {
            $this->assertStringContainsString('Operation error GetAccessPointConfigForObjectProcess', $e);
            $se = $e->getPrevious();
            $this->assertInstanceOf(Oss\Exception\ServiceException::class, $se);
            if ($se instanceof Oss\Exception\ServiceException) {
                $this->assertEquals('NoSuchBucket', $se->getErrorCode());
                $this->assertEquals(404, $se->getStatusCode());
                $this->assertEquals(24, strlen($se->getRequestId()));
            }
        }

        // DeleteAccessPointPolicyForObjectProcess
        try {
            $client->deleteAccessPointPolicyForObjectProcess(new Oss\Models\DeleteAccessPointPolicyForObjectProcessRequest(
                bucket: $bucketName,
                accessPointForObjectProcessName: $objectProcessName,
            ));
            $this->assertTrue(false, "should not here");
        } catch (Oss\Exception\OperationException $e) {
            $this->assertStringContainsString('Operation error DeleteAccessPointPolicyForObjectProcess', $e);
            $se = $e->getPrevious();
            $this->assertInstanceOf(Oss\Exception\ServiceException::class, $se);
            if ($se instanceof Oss\Exception\ServiceException) {
                $this->assertEquals('NoSuchBucket', $se->getErrorCode());
                $this->assertEquals(404, $se->getStatusCode());
                $this->assertEquals(24, strlen($se->getRequestId()));
            }
        }

        // DeleteAccessPointForObjectProcess
        try {
            $client->deleteAccessPointForObjectProcess(new Oss\Models\DeleteAccessPointForObjectProcessRequest(
                bucket: $bucketName,
                accessPointForObjectProcessName: $objectProcessName,
            ));
            $this->assertTrue(false, "should not here");
        } catch (Oss\Exception\OperationException $e) {
            $this->assertStringContainsString('Operation error DeleteAccessPointForObjectProcess', $e);
            $se = $e->getPrevious();
            $this->assertInstanceOf(Oss\Exception\ServiceException::class, $se);
            if ($se instanceof Oss\Exception\ServiceException) {
                $this->assertEquals('NoSuchBucket', $se->getErrorCode());
                $this->assertEquals(404, $se->getStatusCode());
                $this->assertEquals(24, strlen($se->getRequestId()));
            }
        }
    }
}