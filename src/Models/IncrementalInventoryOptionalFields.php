<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class IncrementalInventoryOptionalFields
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'OptionalFields')]
final class IncrementalInventoryOptionalFields extends Model
{
    /**
     * The optional fields included in OSS incremental inventory reports.
     * @var array<string>|null
     */
    #[XmlElement(rename: 'Field', type: 'string')]
    public ?array $fields;

    /**
     * IncrementalInventoryOptionalFields constructor.
     * @param array<string>|null $fields The optional fields included in OSS incremental inventory reports.
     */
    public function __construct(
        ?array $fields = null
    )
    {
        $this->fields = $fields;
    }
}
