<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;
use AlibabaCloud\Oss\V2\Annotation\RequiredProperty;

/**
 * The request for the PutAgenticBucketStatus operation.
 * Class PutAgenticBucketStatusRequest
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class PutAgenticBucketStatusRequest extends RequestModel
{
    /**
     * The name of the bucket.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'host', rename: 'bucket', type: 'string')]
    public ?string $bucket;

    /**
     * The status configuration to apply to the agentic bucket.
     * @var AgenticBucketStatus|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'body', rename: 'AgenticBucketStatus', type: 'xml')]
    public ?AgenticBucketStatus $agenticBucketStatus;

    /**
     * PutAgenticBucketStatusRequest constructor.
     * @param string|null $bucket The name of the bucket.
     * @param AgenticBucketStatus|null $agenticBucketStatus The status configuration to apply to the agentic bucket.
     * @param array|null $options
     */
    public function __construct(
        ?string $bucket = null,
        ?AgenticBucketStatus $agenticBucketStatus = null,
        ?array $options = null
    )
    {
        $this->bucket = $bucket;
        $this->agenticBucketStatus = $agenticBucketStatus;
        parent::__construct($options);
    }
}
