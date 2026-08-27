<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;
use AlibabaCloud\Oss\V2\Annotation\TagBody;

/**
 * The result for the GetAgenticBucketAcl operation.
 * Class GetAgenticBucketAclResult
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class GetAgenticBucketAclResult extends ResultModel
{
    /**
     * The container that stores the ACL information.
     * @var AccessControlPolicy|null
     */
    #[TagBody(rename: 'AccessControlPolicy', type: AccessControlPolicy::class, format: 'xml')]
    public ?AccessControlPolicy $accessControlPolicy;

    /**
     * GetAgenticBucketAclResult constructor.
     * @param AccessControlPolicy|null $accessControlPolicy The container that stores the ACL information.
     */
    public function __construct(
        ?AccessControlPolicy $accessControlPolicy = null
    )
    {
        $this->accessControlPolicy = $accessControlPolicy;
    }
}
