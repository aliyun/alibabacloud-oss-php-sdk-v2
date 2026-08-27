<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;
use AlibabaCloud\Oss\V2\Annotation\RequiredProperty;

/**
 * The request for the CreateAgenticBucket operation.
 * Class CreateAgenticBucketRequest
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class CreateAgenticBucketRequest extends RequestModel
{
    /**
     * The name of the bucket.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'host', rename: 'bucket', type: 'string')]
    public ?string $bucket;

    /**
     * The configuration of the agentic bucket to create.
     * @var CreateAgenticBucketConfiguration|null
     */
    #[TagProperty(tag: '', position: 'body', rename: 'CreateAgenticBucketConfiguration', type: 'xml')]
    public ?CreateAgenticBucketConfiguration $createAgenticBucketConfiguration;

    /**
     * CreateAgenticBucketRequest constructor.
     * @param string|null $bucket The name of the bucket.
     * @param CreateAgenticBucketConfiguration|null $createAgenticBucketConfiguration The configuration of the agentic bucket to create.
     * @param array|null $options
     */
    public function __construct(
        ?string $bucket = null,
        ?CreateAgenticBucketConfiguration $createAgenticBucketConfiguration = null,
        ?array $options = null
    )
    {
        $this->bucket = $bucket;
        $this->createAgenticBucketConfiguration = $createAgenticBucketConfiguration;
        parent::__construct($options);
    }
}
