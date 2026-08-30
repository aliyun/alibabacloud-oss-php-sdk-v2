<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class MetaQueryRespFileInsights
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'Insights')]
final class MetaQueryFileInsights extends Model
{
    /**
     * The description of the video file.
     * @var MetaQueryFileInsightsVideo|null
     */
    #[XmlElement(rename: 'Video', type: MetaQueryFileInsightsVideo::class)]
    public ?MetaQueryFileInsightsVideo $video;

    /**
     * The description of the image file.
     * @var MetaQueryFileInsightsImage|null
     */
    #[XmlElement(rename: 'Image', type: MetaQueryFileInsightsImage::class)]
    public ?MetaQueryFileInsightsImage $image;

    /**
     * MetaQueryRespFileInsights constructor.
     * @param MetaQueryFileInsightsVideo|null $video The description of the video file.
     * @param MetaQueryFileInsightsImage|null $image The description of the image file.
     */
    public function __construct(
        ?MetaQueryFileInsightsVideo $video = null,
        ?MetaQueryFileInsightsImage $image = null
    )
    {
        $this->video = $video;
        $this->image = $image;
    }
}