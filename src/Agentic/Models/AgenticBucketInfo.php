<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;
use AlibabaCloud\Oss\V2\Models\ServerSideEncryptionRule;

/**
 * Class AgenticBucketInfo
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
#[XmlRoot(name: 'AgenticBucketInfo')]
final class AgenticBucketInfo extends Model
{
    /**
     * The name of the agentic bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'Name', type: 'string')]
    public ?string $name;

    /**
     * The owner of the agentic bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'Owner', type: 'string')]
    public ?string $owner;

    /**
     * The region in which the agentic bucket is located.
     * @var string|null
     */
    #[XmlElement(rename: 'Region', type: 'string')]
    public ?string $region;

    /**
     * The storage class of the agentic bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'StorageClass', type: 'string')]
    public ?string $storageClass;

    /**
     * The data redundancy type of the agentic bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'DataRedundancyType', type: 'string')]
    public ?string $dataRedundancyType;

    /**
     * The status of the agentic bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'Status', type: 'string')]
    public ?string $status;

    /**
     * The resource type of the agentic bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'BucketResourceType', type: 'string')]
    public ?string $bucketResourceType;

    /**
     * The time when the agentic bucket was created.
     * @var string|null
     */
    #[XmlElement(rename: 'CreateTime', type: 'string')]
    public ?string $createTime;

    /**
     * The access control list of the agentic bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'ACL', type: 'string')]
    public ?string $acl;

    /**
     * The public access block status of the agentic bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'PublicAccessBlock', type: 'string')]
    public ?string $publicAccessBlock;

    /**
     * The server-side encryption rule of the agentic bucket.
     * @var ServerSideEncryptionRule|null
     */
    #[XmlElement(rename: 'ServerSideEncryptionRule', type: ServerSideEncryptionRule::class)]
    public ?ServerSideEncryptionRule $serverSideEncryptionRule;

    /**
     * The versioning status of the agentic bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'Versioning', type: 'string')]
    public ?string $versioning;

    /**
     * The bucket policy of the agentic bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'BucketPolicy', type: 'string')]
    public ?string $bucketPolicy;

    /**
     * AgenticBucketInfo constructor.
     * @param string|null $name The name of the agentic bucket.
     * @param string|null $owner The owner of the agentic bucket.
     * @param string|null $region The region in which the agentic bucket is located.
     * @param string|null $storageClass The storage class of the agentic bucket.
     * @param string|null $dataRedundancyType The data redundancy type of the agentic bucket.
     * @param string|null $status The status of the agentic bucket.
     * @param string|null $bucketResourceType The resource type of the agentic bucket.
     * @param string|null $createTime The time when the agentic bucket was created.
     * @param string|null $acl The access control list of the agentic bucket.
     * @param string|null $publicAccessBlock The public access block status of the agentic bucket.
     * @param ServerSideEncryptionRule|null $serverSideEncryptionRule The server-side encryption rule of the agentic bucket.
     * @param string|null $versioning The versioning status of the agentic bucket.
     * @param string|null $bucketPolicy The bucket policy of the agentic bucket.
     */
    public function __construct(
        ?string $name = null,
        ?string $owner = null,
        ?string $region = null,
        ?string $storageClass = null,
        ?string $dataRedundancyType = null,
        ?string $status = null,
        ?string $bucketResourceType = null,
        ?string $createTime = null,
        ?string $acl = null,
        ?string $publicAccessBlock = null,
        ?ServerSideEncryptionRule $serverSideEncryptionRule = null,
        ?string $versioning = null,
        ?string $bucketPolicy = null
    )
    {
        $this->name = $name;
        $this->owner = $owner;
        $this->region = $region;
        $this->storageClass = $storageClass;
        $this->dataRedundancyType = $dataRedundancyType;
        $this->status = $status;
        $this->bucketResourceType = $bucketResourceType;
        $this->createTime = $createTime;
        $this->acl = $acl;
        $this->publicAccessBlock = $publicAccessBlock;
        $this->serverSideEncryptionRule = $serverSideEncryptionRule;
        $this->versioning = $versioning;
        $this->bucketPolicy = $bucketPolicy;
    }
}
