<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Paginator;

use AlibabaCloud\Oss\V2\Agentic\AgenticBucketClient;
use AlibabaCloud\Oss\V2\Agentic\Models;

/**
 * A paginator for ListBucketSpaces
 * Class ListBucketSpacesPaginator
 * @package AlibabaCloud\Oss\V2\Agentic\Paginator
 */
final class ListBucketSpacesPaginator
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
     * ListBucketSpacesPaginator constructor.
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
     * Iterates over the bucket spaces.
     * @param Models\ListBucketSpacesRequest $request The request for the ListBucketSpaces operation.
     * @param array $args accepts the following:
     * - limit int: The maximum number of items in the response.
     * @return \Generator<Models\ListBucketSpacesResult>
     */
    public function iterPage(Models\ListBucketSpacesRequest $request, array $args = []): \Generator
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
            $result = $this->client->listBucketSpaces($req, $args);
            yield $result;

            $firstPage = false;
            $isTruncated = $result->isTruncated ?? false;
            $req->continuationToken = $result->nextContinuationToken;
        }
    }

    /**
     * Iterates over the bucket spaces asynchronously.
     * @param Models\ListBucketSpacesRequest $request The request for the ListBucketSpaces operation.
     * @param array $args accepts the following:
     * - limit int: The maximum number of items in the response.
     * @return \Generator<\GuzzleHttp\Promise\Promise>
     */
    public function iterPageAsync(Models\ListBucketSpacesRequest $request, array $args = []): \Generator
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
            $res = $this->client->listBucketSpacesAsync($req, $args);
            $resIsTruncated = false;
            $resNextToken = '';
            yield $res->then(function (Models\ListBucketSpacesResult $result) use (&$resIsTruncated, &$resNextToken) {
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
