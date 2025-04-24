<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class AccessPointActions
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'Actions')]
final class AccessPointActions extends Model
{
    /**
     * The supported OSS API operations. Only the GetObject operation is supported.
     * @var array<string>|null
     */
    #[XmlElement(rename: 'Action', type: 'string')]
    public ?array $actions;

    /**
     * AccessPointActions constructor.
     * @param array<string>|null $actions The supported OSS API operations.
     */
    public function __construct(
        ?array $actions = null
    )
    {
        $this->actions = $actions;
    }
}