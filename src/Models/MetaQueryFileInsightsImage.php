<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class MetaQueryFileInsightsImage
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'Image')]
final class MetaQueryFileInsightsImage extends Model
{
    /**
     * A brief description.
     * @var string|null
     */
    #[XmlElement(rename: 'Caption', type: 'string')]
    public ?string $caption;

    /**
     * A detailed description.
     * @var string|null
     */
    #[XmlElement(rename: 'Description', type: 'string')]
    public ?string $description;

    /**
     * MetaQueryRespFileInsightsImage constructor.
     * @param string|null $caption A brief description.
     * @param string|null $description A detailed description.
     */
    public function __construct(
        ?string $caption = null,
        ?string $description = null
    )
    {
        $this->caption = $caption;
        $this->description = $description;
    }
}