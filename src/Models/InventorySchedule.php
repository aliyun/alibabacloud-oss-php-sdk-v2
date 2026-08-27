<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class InventorySchedule
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'InventorySchedule')]
final class InventorySchedule extends Model
{
    /**
     * The frequency at which the inventory list is exported. Valid values:- Daily: The inventory list is exported on a daily basis. - Weekly: The inventory list is exported on a weekly basis.
     * Sees InventoryFrequencyType for supported values.
     * @var string|null
     */
    #[XmlElement(rename: 'Frequency', type: 'string')]
    public ?string $frequency;


    /**
     * The day of the month on which the inventory list is exported. This parameter is required if the Frequency is Monthly.
     * @var int|null
     */
    #[XmlElement(rename: 'DayOfMonth', type: 'int')]
    public ?int $dayOfMonth;

    /**
     * InventorySchedule constructor.
     * @param string|null $frequency The frequency at which the inventory list is exported.
     * @param int|null $dayOfMonth The day of the month on which the inventory list is exported.
     */
    public function __construct(
        ?string $frequency = null,
        ?int    $dayOfMonth = null
    )
    {
        $this->frequency = $frequency;
        $this->dayOfMonth = $dayOfMonth;
    }
}