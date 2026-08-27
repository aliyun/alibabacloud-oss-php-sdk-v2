<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;

/**
 * Class BucketSpaceSummary
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class BucketSpaceSummary extends Model
{
    /**
     * The name of the bucket space.
     * @var string|null
     */
    #[XmlElement(rename: 'Name', type: 'string')]
    public ?string $name;

    /**
     * The location of the bucket space.
     * @var string|null
     */
    #[XmlElement(rename: 'Location', type: 'string')]
    public ?string $location;

    /**
     * The time when the bucket space was created.
     * @var string|null
     */
    #[XmlElement(rename: 'CreationDate', type: 'string')]
    public ?string $creationDate;

    /**
     * The storage class of the bucket space.
     * @var string|null
     */
    #[XmlElement(rename: 'StorageClass', type: 'string')]
    public ?string $storageClass;

    /**
     * BucketSpaceSummary constructor.
     * @param string|null $name The name of the bucket space.
     * @param string|null $location The location of the bucket space.
     * @param string|null $creationDate The time when the bucket space was created.
     * @param string|null $storageClass The storage class of the bucket space.
     */
    public function __construct(
        ?string $name = null,
        ?string $location = null,
        ?string $creationDate = null,
        ?string $storageClass = null
    )
    {
        $this->name = $name;
        $this->location = $location;
        $this->creationDate = $creationDate;
        $this->storageClass = $storageClass;
    }
}
