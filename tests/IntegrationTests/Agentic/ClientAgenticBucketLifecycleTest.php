<?php

namespace IntegrationTests\Agentic;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'TestAgentic.php';

use AlibabaCloud\Oss\V2\Agentic\Models;

/**
 * The two-phase deletion of an agentic bucket: putAgenticBucketStatus(Disabled) succeeds, but the
 * bucket only becomes deletable roughly 24 hours later, so the deleteAgenticBucket that follows
 * immediately is answered with 409 / AgenticBucketNotReady. A create-then-delete round trip is
 * therefore impossible within a single run; the reaper reclaims the bucket in a later run.
 *
 * The scenario runs against the bucket created by this class's own fixture, so that disabling it
 * cannot disturb the scenarios of the sibling classes.
 */
class ClientAgenticBucketLifecycleTest extends TestAgentic
{
    public function testDisableThenDeleteNotReady()
    {
        $client = self::$agenticClient;
        $bucket = self::$agenticBucketName;

        $putResult = $client->putAgenticBucketStatus(new Models\PutAgenticBucketStatusRequest(
            $bucket,
            new Models\AgenticBucketStatus('Disabled')
        ));
        $this->assertEquals(200, $putResult->statusCode);

        try {
            $client->deleteAgenticBucket(new Models\DeleteAgenticBucketRequest($bucket));
            $this->assertTrue(false, "should not here");
        } catch (\Throwable $ec) {
            $se = self::findServiceException($ec);
            $this->assertNotNull($se);
            $this->assertTrue(
                $se->getStatusCode() === 409 || $se->getErrorCode() === 'AgenticBucketNotReady',
                'expected 409/AgenticBucketNotReady, got status=' . strval($se->getStatusCode())
                . ' code=' . strval($se->getErrorCode())
            );
        }
    }
}
