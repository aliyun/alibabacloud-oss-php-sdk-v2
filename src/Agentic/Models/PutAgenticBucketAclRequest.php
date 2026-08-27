<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;
use AlibabaCloud\Oss\V2\Annotation\RequiredProperty;

/**
 * The request for the PutAgenticBucketAcl operation.
 * Class PutAgenticBucketAclRequest
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class PutAgenticBucketAclRequest extends RequestModel
{
    /**
     * The name of the bucket.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'host', rename: 'bucket', type: 'string')]
    public ?string $bucket;

    /**
     * The access control list (ACL) of the agentic bucket.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-acl', type: 'string')]
    public ?string $acl;

    /**
     * PutAgenticBucketAclRequest constructor.
     * @param string|null $bucket The name of the bucket.
     * @param string|null $acl The access control list (ACL) of the agentic bucket.
     * @param array|null $options
     */
    public function __construct(
        ?string $bucket = null,
        ?string $acl = null,
        ?array $options = null
    )
    {
        $this->bucket = $bucket;
        $this->acl = $acl;
        parent::__construct($options);
    }
}
