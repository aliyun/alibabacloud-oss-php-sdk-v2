<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;

/**
 * The result for the ListAgenticBuckets operation.
 * Class ListAgenticBucketsResult
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class ListAgenticBucketsResult extends ResultModel
{
    /**
     * The region in which the agentic buckets are located.
     * @var string|null
     */
    public ?string $region;

    /**
     * The owner of the agentic buckets.
     * @var string|null
     */
    public ?string $owner;

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
     * Indicates whether the returned results are truncated.
     * @var bool|null
     */
    public ?bool $isTruncated;

    /**
     * The container that stores the information about multiple agentic buckets.
     * @var array<AgenticBucketSummary>|null
     */
    public ?array $agenticBuckets;

    /**
     * ListAgenticBucketsResult constructor.
     * @param string|null $region The region in which the agentic buckets are located.
     * @param string|null $owner The owner of the agentic buckets.
     * @param string|null $continuationToken The token from which the list operation started.
     * @param string|null $nextContinuationToken The token used to continue the next list operation.
     * @param bool|null $isTruncated Indicates whether the returned results are truncated.
     * @param array<AgenticBucketSummary>|null $agenticBuckets The container that stores the information about multiple agentic buckets.
     */
    public function __construct(
        ?string $region = null,
        ?string $owner = null,
        ?string $continuationToken = null,
        ?string $nextContinuationToken = null,
        ?bool $isTruncated = null,
        ?array $agenticBuckets = null
    )
    {
        $this->region = $region;
        $this->owner = $owner;
        $this->continuationToken = $continuationToken;
        $this->nextContinuationToken = $nextContinuationToken;
        $this->isTruncated = $isTruncated;
        $this->agenticBuckets = $agenticBuckets;
    }
}
