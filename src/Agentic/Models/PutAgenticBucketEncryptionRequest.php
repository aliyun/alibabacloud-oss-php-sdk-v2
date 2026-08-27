<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;
use AlibabaCloud\Oss\V2\Annotation\RequiredProperty;
use AlibabaCloud\Oss\V2\Models\ServerSideEncryptionRule;

/**
 * The request for the PutAgenticBucketEncryption operation.
 * Class PutAgenticBucketEncryptionRequest
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class PutAgenticBucketEncryptionRequest extends RequestModel
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
     * @var ServerSideEncryptionRule|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'body', rename: 'ServerSideEncryptionRule', type: 'xml')]
    public ?ServerSideEncryptionRule $serverSideEncryptionRule;

    /**
     * PutAgenticBucketEncryptionRequest constructor.
     * @param string|null $bucket The name of the bucket.
     * @param ServerSideEncryptionRule|null $serverSideEncryptionRule The request body schema.
     * @param array|null $options
     */
    public function __construct(
        ?string $bucket = null,
        ?ServerSideEncryptionRule $serverSideEncryptionRule = null,
        ?array $options = null
    )
    {
        $this->bucket = $bucket;
        $this->serverSideEncryptionRule = $serverSideEncryptionRule;
        parent::__construct($options);
    }
}
