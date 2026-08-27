<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Paginator;

use AlibabaCloud\Oss\V2\Agentic\AgenticBucketClient;
use AlibabaCloud\Oss\V2\Agentic\Models;

/**
 * A paginator for ListAgenticBuckets
 * Class ListAgenticBucketsPaginator
 * @package AlibabaCloud\Oss\V2\Agentic\Paginator
 */
final class ListAgenticBucketsPaginator
{
    /**
     * @var AgenticBucketClient
     */
    private AgenticBucketClient $client;

    /**
     * @var int|null
     */
    private ?int $limit;

    /**
     * ListAgenticBucketsPaginator constructor.
     * @param AgenticBucketClient $client
     * @param array $args accepts the following:
     * - limit int: The maximum number of items in the response.
     */
    public function __construct(AgenticBucketClient $client, array $args = [])
    {
        $this->client = $client;
        $this->limit = (isset($args['limit']) && is_int($args['limit'])) ? $args['limit'] : null;
    }

    /**
     * Iterates over the agentic buckets.
     * @param Models\ListAgenticBucketsRequest $request The request for the ListAgenticBuckets operation.
     * @param array $args accepts the following:
     * - limit int: The maximum number of items in the response.
     * @return \Generator<Models\ListAgenticBucketsResult>
     */
    public function iterPage(Models\ListAgenticBucketsRequest $request, array $args = []): \Generator
    {
        $limit = $args['limit'] ?? $this->limit;
        if (isset($args['limit'])) {
            unset($args['limit']);
        }
        $req = clone $request;
        if (isset($limit) && is_int($limit)) {
            $req->maxKeys = $limit;
        }

        $firstPage = true;
        $isTruncated = false;

        while ($firstPage || $isTruncated) {
            $result = $this->client->listAgenticBuckets($req, $args);
            yield $result;

            $firstPage = false;
            $isTruncated = $result->isTruncated ?? false;
            $req->continuationToken = $result->nextContinuationToken;
        }
    }

    /**
     * Iterates over the agentic buckets asynchronously.
     * @param Models\ListAgenticBucketsRequest $request The request for the ListAgenticBuckets operation.
     * @param array $args accepts the following:
     * - limit int: The maximum number of items in the response.
     * @return \Generator<\GuzzleHttp\Promise\Promise>
     */
    public function iterPageAsync(Models\ListAgenticBucketsRequest $request, array $args = []): \Generator
    {
        $limit = $args['limit'] ?? $this->limit;
        if (isset($args['limit'])) {
            unset($args['limit']);
        }
        $req = clone $request;
        if (isset($limit) && is_int($limit)) {
            $req->maxKeys = $limit;
        }

        $firstPage = true;
        $isTruncated = false;

        while ($firstPage || $isTruncated) {
            $res = $this->client->listAgenticBucketsAsync($req, $args);
            $resIsTruncated = false;
            $resNextToken = '';
            yield $res->then(function (Models\ListAgenticBucketsResult $result) use (&$resIsTruncated, &$resNextToken) {
                $resIsTruncated = $result->isTruncated ?? false;
                $resNextToken = $result->nextContinuationToken;
                return $result;
            });

            $firstPage = false;
            $isTruncated = $resIsTruncated;
            $req->continuationToken = $resNextToken;
        }
    }
}
