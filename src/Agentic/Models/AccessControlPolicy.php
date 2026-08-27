<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;
use AlibabaCloud\Oss\V2\Models\Owner;
use AlibabaCloud\Oss\V2\Models\AccessControlList;

/**
 * Class AccessControlPolicy
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
#[XmlRoot(name: 'AccessControlPolicy')]
final class AccessControlPolicy extends Model
{
    /**
     * The container that stores the information about the bucket owner.
     * @var Owner|null
     */
    #[XmlElement(rename: 'Owner', type: Owner::class)]
    public ?Owner $owner;

    /**
     * The container that stores the access control list (ACL) information.
     * @var AccessControlList|null
     */
    #[XmlElement(rename: 'AccessControlList', type: AccessControlList::class)]
    public ?AccessControlList $accessControlList;

    /**
     * AccessControlPolicy constructor.
     * @param Owner|null $owner The container that stores the information about the bucket owner.
     * @param AccessControlList|null $accessControlList The container that stores the ACL information.
     */
    public function __construct(
        ?Owner $owner = null,
        ?AccessControlList $accessControlList = null
    )
    {
        $this->owner = $owner;
        $this->accessControlList = $accessControlList;
    }
}
