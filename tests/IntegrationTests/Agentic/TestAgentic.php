<?php

namespace IntegrationTests\Agentic;

use AlibabaCloud\Oss\V2 as Oss;
use AlibabaCloud\Oss\V2\Agentic\AgenticBucketClient;
use AlibabaCloud\Oss\V2\Agentic\BucketSpaceClient;
use AlibabaCloud\Oss\V2\Agentic\Models;
use AlibabaCloud\Oss\V2\Agentic\Paginator\ListAgenticBucketsPaginator;
use AlibabaCloud\Oss\V2\Agentic\Paginator\ListBucketSpacesPaginator;

/**
 * Shared helpers for the agentic integration tests: client factories, name builders and the
 * prefix based reaper that bounds the backlog left by the two-phase agentic bucket lifecycle.
 *
 * Deleting an agentic bucket requires putAgenticBucketStatus(Disabled) first, and the bucket only
 * becomes deletable roughly 24 hours later. A run therefore cannot delete the bucket it creates; it
 * only marks it Disabled and reclaims the ones left behind by earlier runs.
 */
class TestAgentic extends \PHPUnit\Framework\TestCase
{
    static $ACCESS_ID;
    static $ACCESS_KEY;
    static $ENDPOINT;
    static $REGION;
    static $ACCOUNT_ID;

    // Keep short: the resolved physical name {bucket}-{accountId}-{region}-ab-apsr is used as a DNS
    // label, so prefix plus random part must stay within 23 characters
    // (63 - 1 - 16 accountId - 1 - 14 region - 8 for '-ab-apsr').
    // The 'ab' / 'bs' markers are what the reaper filters on.
    public static $BUCKETNAME_PREFIX = "php-ab-";
    public static $BUCKETSPACE_NAME_PREFIX = "php-bs-";

    /** The tail the service appends to an agentic bucket name. */
    const AGENTIC_BUCKET_SUFFIX = 'ab-apsr';

    /** The tail the service appends to a bucket space name. */
    const BUCKET_SPACE_SUFFIX = 'bs-apsr';

    const RANDOM_NAME_LENGTH = 6;
    const LIST_RETRY_TIMES = 10;
    const LIST_RETRY_INTERVAL_SECONDS = 3;

    /** The agentic bucket shared by the scenarios of the current test class. */
    protected static ?string $agenticBucketName = null;

    protected static ?AgenticBucketClient $agenticClient = null;

    public static function setUpBeforeClass(): void
    {
        self::$ACCESS_ID = getenv("OSS_TEST_ACCESS_KEY_ID");
        self::$ACCESS_KEY = getenv("OSS_TEST_ACCESS_KEY_SECRET");
        self::$ENDPOINT = getenv("OSS_TEST_ENDPOINT");
        self::$REGION = getenv("OSS_TEST_REGION") ?: 'cn-hangzhou';
        self::$ACCOUNT_ID = getenv("OSS_TEST_RAM_UID") ?: getenv("OSS_TEST_USER_ID");

        // One bucket per test class: a scenario that disables it must not disturb the scenarios of
        // the sibling classes, and PHPUnit gives no ordering guarantee across classes.
        self::$agenticClient = self::newAgenticClient();
        self::$agenticBucketName = self::genAgenticBucketName();
        self::createAgenticBucket(self::$agenticClient, self::$agenticBucketName);
    }

    public static function tearDownAfterClass(): void
    {
        // A bucket left Enabled can never be reclaimed by any later run, so disable this run's own
        // bucket even when the scenario failed; only then reap the backlog of the earlier runs.
        self::disableAgenticBucketQuietly(self::$agenticBucketName);
        self::reapDisabledAgenticBuckets();
        self::$agenticBucketName = null;
        self::$agenticClient = null;
    }

    public static function newConfig(): Oss\Config
    {
        $cfg = Oss\Config::loadDefault();
        $cfg->setCredentialsProvider(new Oss\Credentials\StaticCredentialsProvider(
            self::$ACCESS_ID,
            self::$ACCESS_KEY
        ));
        $cfg->setRegion(self::$REGION);
        $cfg->setEndpoint(self::$ENDPOINT);
        $cfg->setAccountId(self::$ACCOUNT_ID);
        return $cfg;
    }

    public static function newAgenticClient(): AgenticBucketClient
    {
        return new AgenticBucketClient(self::newConfig());
    }

    public static function newAgenticClientPathStyle(): AgenticBucketClient
    {
        $cfg = self::newConfig();
        $cfg->setUsePathStyle(true);
        return new AgenticBucketClient($cfg);
    }

    public static function newInvalidAkAgenticClient(): AgenticBucketClient
    {
        $cfg = Oss\Config::loadDefault();
        $cfg->setCredentialsProvider(new Oss\Credentials\StaticCredentialsProvider(
            'invalid-ak',
            'invalid'
        ));
        $cfg->setRegion(self::$REGION);
        $cfg->setEndpoint(self::$ENDPOINT);
        $cfg->setAccountId(self::$ACCOUNT_ID);
        return new AgenticBucketClient($cfg);
    }

    /** A client that expands a short name to {bucket}-{accountId}-{region}-bs-apsr. */
    public static function newBucketSpaceClient(): Oss\Client
    {
        return BucketSpaceClient::newClient(self::newConfig());
    }

    public static function newBucketSpaceClientPathStyle(): Oss\Client
    {
        $cfg = self::newConfig();
        $cfg->setUsePathStyle(true);
        return BucketSpaceClient::newClient($cfg);
    }

    /** A plain client, it addresses bucket spaces by their full physical name. */
    public static function newPlainClient(): Oss\Client
    {
        return new Oss\Client(self::newConfig());
    }

    public static function genAgenticBucketName(): string
    {
        return self::$BUCKETNAME_PREFIX . self::randStr(self::RANDOM_NAME_LENGTH);
    }

    public static function genBucketSpaceName(): string
    {
        return self::$BUCKETSPACE_NAME_PREFIX . self::randStr(self::RANDOM_NAME_LENGTH);
    }

    // Fixed length: no generated name may be a prefix of another, otherwise the reaper would also
    // match the bucket of a concurrently running job.
    private static function randStr(int $length): string
    {
        $letters = 'abcdefghijklmnopqrstuvwxyz';
        $name = '';
        for ($i = 0; $i < $length; $i++) {
            $name .= $letters[rand(0, strlen($letters) - 1)];
        }
        return $name;
    }

    /** Resolves a short name to the server side full name {bucket}-{accountId}-{region}-{suffix}. */
    public static function buildFullName(string $bucket, string $suffix): string
    {
        return sprintf('%s-%s-%s-%s', $bucket, self::$ACCOUNT_ID, self::$REGION, $suffix);
    }

    /**
     * Strips the resolved tail so a listed physical name can be handed back to a client that
     * re-expands short names.
     */
    public static function toShortName(string $fullName, string $suffix): string
    {
        $tail = sprintf('-%s-%s-%s', self::$ACCOUNT_ID, self::$REGION, $suffix);
        if (strlen($fullName) > strlen($tail) && substr($fullName, -strlen($tail)) === $tail) {
            return substr($fullName, 0, strlen($fullName) - strlen($tail));
        }
        return $fullName;
    }

    public static function createAgenticBucket(AgenticBucketClient $client, string $bucket): void
    {
        try {
            $client->createAgenticBucket(new Models\CreateAgenticBucketRequest(
                $bucket,
                new Models\CreateAgenticBucketConfiguration('Standard', 'LRS')
            ));
        } catch (\Throwable $e) {
            self::skipIfAgenticProvisioningUnsupported($e);
            throw $e;
        }
        self::waitFor(1);
    }

    // Agentic bucket provisioning must be enabled for the account/region under test.
    // When it is not, the service rejects the create request with MalformedXML; the
    // request the SDK sends is byte-identical to the Java SDK, so this is an
    // environment capability gap rather than an SDK defect -> skip instead of fail.
    protected static function skipIfAgenticProvisioningUnsupported(\Throwable $e): void
    {
        $se = self::findServiceException($e);
        if ($se !== null && $se->getErrorCode() === 'MalformedXML') {
            self::markTestSkipped(
                'Agentic bucket provisioning is not enabled for this account/region: '
                . $se->getErrorMessage()
            );
        }
    }

    /**
     * A newly created agentic bucket only shows up in listAgenticBuckets after a while, so poll.
     * Returns false when it is still missing; the caller skips instead of failing, the existence of
     * the bucket is already asserted by getAgenticBucket.
     */
    public static function waitForAgenticBucketListed(AgenticBucketClient $client, string $bucket): bool
    {
        for ($i = 0; $i < self::LIST_RETRY_TIMES; $i++) {
            $paginator = new ListAgenticBucketsPaginator($client);
            foreach ($paginator->iterPage(new Models\ListAgenticBucketsRequest()) as $page) {
                foreach ($page->agenticBuckets ?? [] as $summary) {
                    if ($summary->name !== null && strpos($summary->name, $bucket) !== false) {
                        return true;
                    }
                }
            }
            self::waitFor(self::LIST_RETRY_INTERVAL_SECONDS);
        }
        return false;
    }

    /** Best-effort: the bucket of the current run must not be left Enabled. */
    public static function disableAgenticBucketQuietly(?string $bucket): void
    {
        if ($bucket === null) {
            return;
        }
        try {
            self::newAgenticClient()->putAgenticBucketStatus(new Models\PutAgenticBucketStatusRequest(
                $bucket,
                new Models\AgenticBucketStatus('Disabled')
            ));
        } catch (\Throwable $ignore) {
        }
    }

    /**
     * Reclaims the agentic buckets left behind by the earlier runs: only the ones already Disabled
     * are touched, an Enabled one may belong to a concurrently running job. Best-effort, every
     * error is swallowed so that teardown never fails.
     */
    public static function reapDisabledAgenticBuckets(): void
    {
        try {
            $client = self::newAgenticClient();
            $paginator = new ListAgenticBucketsPaginator($client);
            foreach ($paginator->iterPage(new Models\ListAgenticBucketsRequest()) as $page) {
                foreach ($page->agenticBuckets ?? [] as $summary) {
                    if ($summary->name === null || strpos($summary->name, self::$BUCKETNAME_PREFIX) !== 0) {
                        continue;
                    }
                    self::reapDisabledAgenticBucket(
                        $client,
                        self::toShortName($summary->name, self::AGENTIC_BUCKET_SUFFIX)
                    );
                }
            }
        } catch (\Throwable $ignore) {
        }
    }

    private static function reapDisabledAgenticBucket(AgenticBucketClient $client, string $bucket): void
    {
        // The list summary carries no status, so fetch it: anything not Disabled is off limits.
        $status = null;
        try {
            $result = $client->getAgenticBucket(new Models\GetAgenticBucketRequest($bucket));
            if ($result->agenticBucketInfo !== null) {
                $status = $result->agenticBucketInfo->status;
            }
        } catch (\Throwable $ignore) {
        }
        if ($status !== 'Disabled') {
            return;
        }
        self::detachAgenticBucketProperties($client, $bucket);
        self::reapBucketSpaces($client, $bucket);
        // Answers 409 AgenticBucketNotReady until the readiness window has elapsed.
        try {
            $client->deleteAgenticBucket(new Models\DeleteAgenticBucketRequest($bucket));
        } catch (\Throwable $ignore) {
        }
    }

    private static function detachAgenticBucketProperties(AgenticBucketClient $client, string $bucket): void
    {
        try {
            $client->deleteAgenticBucketPolicy(new Models\DeleteAgenticBucketPolicyRequest($bucket));
        } catch (\Throwable $ignore) {
        }
        try {
            $client->deleteAgenticBucketEncryption(new Models\DeleteAgenticBucketEncryptionRequest($bucket));
        } catch (\Throwable $ignore) {
        }
        try {
            $client->deleteAgenticBucketPublicAccessBlock(new Models\DeleteAgenticBucketPublicAccessBlockRequest($bucket));
        } catch (\Throwable $ignore) {
        }
    }

    /** Empties and deletes every bucket space of a Disabled agentic bucket. Best-effort. */
    private static function reapBucketSpaces(AgenticBucketClient $client, string $bucket): void
    {
        try {
            $paginator = new ListBucketSpacesPaginator($client);
            foreach ($paginator->iterPage(new Models\ListBucketSpacesRequest($bucket)) as $page) {
                foreach ($page->bucketSpaces ?? [] as $space) {
                    if ($space->name === null) {
                        continue;
                    }
                    // A non-empty bucket space cannot be deleted, and an agentic bucket that still
                    // owns a bucket space cannot be deleted either.
                    self::cleanBucketSpaceObjects($space->name);
                    self::deleteBucketSpaceQuietly($space->name);
                }
            }
        } catch (\Throwable $ignore) {
        }
    }

    /** Empties a bucket space addressed by its full physical name. Best-effort. */
    public static function cleanBucketSpaceObjects(string $spaceFullName): void
    {
        try {
            $client = self::newPlainClient();
            $paginator = new Oss\Paginator\ListObjectsV2Paginator($client);
            foreach ($paginator->iterPage(new Oss\Models\ListObjectsV2Request($spaceFullName)) as $page) {
                foreach ($page->contents ?? [] as $object) {
                    try {
                        $client->deleteObject(new Oss\Models\DeleteObjectRequest($spaceFullName, $object->key));
                    } catch (\Throwable $ignore) {
                    }
                }
            }
        } catch (\Throwable $ignore) {
        }
    }

    /** Deletes a bucket space by its full physical name. Best-effort. */
    public static function deleteBucketSpaceQuietly(string $spaceFullName): void
    {
        try {
            self::newPlainClient()->deleteBucket(new Oss\Models\DeleteBucketRequest($spaceFullName));
        } catch (\Throwable $ignore) {
        }
    }

    public static function waitFor(float $sec): void
    {
        usleep((int)($sec * 1000000));
    }

    protected static function findServiceException(\Throwable $e): ?Oss\Exception\ServiceException
    {
        $cause = $e;
        while ($cause != null) {
            if ($cause instanceof Oss\Exception\ServiceException) {
                return $cause;
            }
            $cause = $cause->getPrevious();
        }
        return null;
    }

    /**
     * A SecondLevelDomainForbidden means the endpoint refuses path-style addressing; that is an
     * endpoint capability rather than an SDK defect, so the caller skips instead of failing.
     */
    protected static function isSecondLevelDomainForbidden(\Throwable $e): bool
    {
        $se = self::findServiceException($e);
        return $se !== null && $se->getErrorCode() === 'SecondLevelDomainForbidden';
    }
}
