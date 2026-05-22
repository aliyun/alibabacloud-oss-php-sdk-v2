<?php

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;
use AlibabaCloud\Oss\V2\Types\Model;

/**
 * Class IncrementalInventory
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'IncrementalInventory')]
final class IncrementalInventory extends Model
{
    /**
     * Specifies whether incremental inventory is enabled.
     * @var bool|null
     */
    #[XmlElement(rename: 'IsEnabled', type: 'bool')]
    public ?bool $isEnabled;

    /**
     * Container for incremental inventory export cycle.
     * @var IncrementInventorySchedule|null
     */
    #[XmlElement(rename: 'Schedule', type: IncrementInventorySchedule::class)]
    public ?IncrementInventorySchedule $schedule;

    /**
     * Configuration container for incremental inventory file attributes.
     * @var IncrementalInventoryOptionalFields|null
     */
    #[XmlElement(rename: 'OptionalFields', type: IncrementalInventoryOptionalFields::class)]
    public ?IncrementalInventoryOptionalFields $optionalFields;

    /**
     * @param bool|null $isEnabled Specifies whether incremental inventory is enabled.
     * @param IncrementInventorySchedule|null $schedule Container for incremental inventory export cycle.
     * @param IncrementalInventoryOptionalFields|null $optionalFields Configuration container for incremental inventory file attributes.
     */
    public function __construct(
        ?bool                               $isEnabled = null,
        ?IncrementInventorySchedule         $schedule = null,
        ?IncrementalInventoryOptionalFields $optionalFields = null
    )
    {
        $this->isEnabled = $isEnabled;
        $this->schedule = $schedule;
        $this->optionalFields = $optionalFields;
    }
}