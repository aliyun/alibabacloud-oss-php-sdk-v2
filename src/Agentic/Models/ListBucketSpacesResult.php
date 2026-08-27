<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;
use AlibabaCloud\Oss\V2\Models\Owner;

/**
 * The result for the ListBucketSpaces operation.
 * Class ListBucketSpacesResult
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class ListBucketSpacesResult extends ResultModel
{
    /**
     * The container that stores the information about the bucket owner.
     * @var Owner|null
     */
    public ?Owner $owner;

    /**
     * The prefix that the names of returned bucket spaces contain.
     * @var string|null
     */
    public ?string $prefix;

    /**
     * The maximum number of bucket spaces that can be returned.
     * @var int|null
     */
    public ?int $maxKeys;

    /**
     * The token from which the list operation started.
     * @var string|null
     */
    public ?string $continuationToken;

    /**
     * The token used to continue the next list operation.
     * @var string|null
     */
    public ?string $nextContinuationToken;

    /**
     * The name of the bucket space after which the list operation began.
     * @var string|null
     */
    public ?string $startAfter;

    /**
     * Indicates whether the returned results are truncated.
     * @var bool|null
     */
    public ?bool $isTruncated;

    /**
     * The container that stores the information about multiple bucket spaces.
     * @var array<BucketSpaceSummary>|null
     */
    public ?array $bucketSpaces;

    /**
     * ListBucketSpacesResult constructor.
     * @param Owner|null $owner The container that stores the information about the bucket owner.
     * @param string|null $prefix The prefix that the names of returned bucket spaces contain.
     * @param int|null $maxKeys The maximum number of bucket spaces that can be returned.
     * @param string|null $continuationToken The token from which the list operation started.
     * @param string|null $nextContinuationToken The token used to continue the next list operation.
     * @param string|null $startAfter The name of the bucket space after which the list operation began.
     * @param bool|null $isTruncated Indicates whether the returned results are truncated.
     * @param array<BucketSpaceSummary>|null $bucketSpaces The container that stores the information about multiple bucket spaces.
     */
    public function __construct(
        ?Owner $owner = null,
        ?string $prefix = null,
        ?int $maxKeys = null,
        ?string $continuationToken = null,
        ?string $nextContinuationToken = null,
        ?string $startAfter = null,
        ?bool $isTruncated = null,
        ?array $bucketSpaces = null
    )
    {
        $this->owner = $owner;
        $this->prefix = $prefix;
        $this->maxKeys = $maxKeys;
        $this->continuationToken = $continuationToken;
        $this->nextContinuationToken = $nextContinuationToken;
        $this->startAfter = $startAfter;
        $this->isTruncated = $isTruncated;
        $this->bucketSpaces = $bucketSpaces;
    }
}
