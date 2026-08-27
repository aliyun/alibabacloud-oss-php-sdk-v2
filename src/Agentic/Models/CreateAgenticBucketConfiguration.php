<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class CreateAgenticBucketConfiguration
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
#[XmlRoot(name: 'CreateAgenticBucketConfiguration')]
final class CreateAgenticBucketConfiguration extends Model
{
    /**
     * The storage class of the bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'StorageClass', type: 'string')]
    public ?string $storageClass;

    /**
     * The data redundancy type of the bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'DataRedundancyType', type: 'string')]
    public ?string $dataRedundancyType;

    /**
     * CreateAgenticBucketConfiguration constructor.
     * @param string|null $storageClass The storage class of the bucket.
     * @param string|null $dataRedundancyType The data redundancy type of the bucket.
     */
    public function __construct(
        ?string $storageClass = null,
        ?string $dataRedundancyType = null
    )
    {
        $this->storageClass = $storageClass;
        $this->dataRedundancyType = $dataRedundancyType;
    }
}
