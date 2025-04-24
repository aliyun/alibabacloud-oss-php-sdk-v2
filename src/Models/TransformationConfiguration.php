<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class TransformationConfiguration
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'TransformationConfiguration')]
final class TransformationConfiguration extends Model
{
    /**
     * The container that stores the operations.
     * @var AccessPointActions|null
     */
    #[XmlElement(rename: 'Actions', type: AccessPointActions::class)]
    public ?AccessPointActions $actions;

    /**
     * The container that stores the content of the transformation configurations.
     * @var ContentTransformation|null
     */
    #[XmlElement(rename: 'ContentTransformation', type: ContentTransformation::class)]
    public ?ContentTransformation $contentTransformation;

    /**
     * TransformationConfiguration constructor.
     * @param AccessPointActions|null $actions The container that stores the operations.
     * @param ContentTransformation|null $contentTransformation The container that stores the content of the transformation configurations.
     */
    public function __construct(
        ?AccessPointActions $actions = null,
        ?ContentTransformation $contentTransformation = null
    )
    {
        $this->actions = $actions;
        $this->contentTransformation = $contentTransformation;
    }
}