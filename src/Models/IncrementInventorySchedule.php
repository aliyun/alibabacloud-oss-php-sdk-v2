<?php

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;
use AlibabaCloud\Oss\V2\Types\Model;

/**
 * Class IncrementInventorySchedule
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'Schedule')]
final class IncrementInventorySchedule extends Model
{

    /**
     * Describes the frequency at which incremental inventory files are exported.
     * @var string|null
     */
    #[XmlElement(rename: 'Frequency', type: 'int')]
    public ?string $frequency;

    /**
     * IncrementInventorySchedule constructor.
     * @param int|null $frequency Describes the frequency at which incremental inventory files are exported.
     */
    public function __construct(
        ?int $frequency = null
    )
    {
        $this->frequency = $frequency;
    }
}