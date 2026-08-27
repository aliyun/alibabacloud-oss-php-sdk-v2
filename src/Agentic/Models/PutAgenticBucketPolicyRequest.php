<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;
use AlibabaCloud\Oss\V2\Annotation\RequiredProperty;

/**
 * The request for the PutAgenticBucketPolicy operation.
 * Class PutAgenticBucketPolicyRequest
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class PutAgenticBucketPolicyRequest extends RequestModel
{
    /**
     * The name of the bucket.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'host', rename: 'bucket', type: 'string')]
    public ?string $bucket;

    /**
     * The policy document, as a JSON string.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'body', rename: 'nop', type: 'string')]
    public ?string $body;

    /**
     * PutAgenticBucketPolicyRequest constructor.
     * @param string|null $bucket The name of the bucket.
     * @param string|null $body The policy document, as a JSON string.
     * @param array|null $options
     */
    public function __construct(
        ?string $bucket = null,
        ?string $body = null,
        ?array $options = null
    )
    {
        $this->bucket = $bucket;
        $this->body = $body;
        parent::__construct($options);
    }
}
