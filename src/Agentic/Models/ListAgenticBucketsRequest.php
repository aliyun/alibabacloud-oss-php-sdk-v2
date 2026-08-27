<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;

/**
 * The request for the ListAgenticBuckets operation.
 * Class ListAgenticBucketsRequest
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class ListAgenticBucketsRequest extends RequestModel
{
    /**
     * The token from which the list operation must start.
     * @var string|null
     */
    #[TagProperty(tag: '', position: 'query', rename: 'continuation-token', type: 'string')]
    public ?string $continuationToken;

    /**
     * The maximum number of agentic buckets that can be returned.
     * @var int|null
     */
    #[TagProperty(tag: '', position: 'query', rename: 'max-keys', type: 'int')]
    public ?int $maxKeys;

    /**
     * ListAgenticBucketsRequest constructor.
     * @param string|null $continuationToken The token from which the list operation must start.
     * @param int|null $maxKeys The maximum number of agentic buckets that can be returned.
     * @param array|null $options
     */
    public function __construct(
        ?string $continuationToken = null,
        ?int $maxKeys = null,
        ?array $options = null
    )
    {
        $this->continuationToken = $continuationToken;
        $this->maxKeys = $maxKeys;
        parent::__construct($options);
    }
}
