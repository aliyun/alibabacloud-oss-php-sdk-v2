<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;

/**
 * Class AgenticBucketSummary
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class AgenticBucketSummary extends Model
{
    /**
     * The name of the agentic bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'Name', type: 'string')]
    public ?string $name;

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
     * The time when the agentic bucket was created.
     * @var string|null
     */
    #[XmlElement(rename: 'CreateTime', type: 'string')]
    public ?string $createTime;

    /**
     * AgenticBucketSummary constructor.
     * @param string|null $name The name of the agentic bucket.
     * @param string|null $storageClass The storage class of the agentic bucket.
     * @param string|null $dataRedundancyType The data redundancy type of the agentic bucket.
     * @param string|null $createTime The time when the agentic bucket was created.
     */
    public function __construct(
        ?string $name = null,
        ?string $storageClass = null,
        ?string $dataRedundancyType = null,
        ?string $createTime = null
    )
    {
        $this->name = $name;
        $this->storageClass = $storageClass;
        $this->dataRedundancyType = $dataRedundancyType;
        $this->createTime = $createTime;
    }
}
