<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;
use AlibabaCloud\Oss\V2\Annotation\RequiredProperty;
use AlibabaCloud\Oss\V2\Models\PublicAccessBlockConfiguration;

/**
 * The request for the PutAgenticBucketPublicAccessBlock operation.
 * Class PutAgenticBucketPublicAccessBlockRequest
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class PutAgenticBucketPublicAccessBlockRequest extends RequestModel
{
    /**
     * The name of the bucket.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'host', rename: 'bucket', type: 'string')]
    public ?string $bucket;

    /**
     * The request body schema.
     * @var PublicAccessBlockConfiguration|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'body', rename: 'PublicAccessBlockConfiguration', type: 'xml')]
    public ?PublicAccessBlockConfiguration $publicAccessBlockConfiguration;

    /**
     * PutAgenticBucketPublicAccessBlockRequest constructor.
     * @param string|null $bucket The name of the bucket.
     * @param PublicAccessBlockConfiguration|null $publicAccessBlockConfiguration The request body schema.
     * @param array|null $options
     */
    public function __construct(
        ?string $bucket = null,
        ?PublicAccessBlockConfiguration $publicAccessBlockConfiguration = null,
        ?array $options = null
    )
    {
        $this->bucket = $bucket;
        $this->publicAccessBlockConfiguration = $publicAccessBlockConfiguration;
        parent::__construct($options);
    }
}
