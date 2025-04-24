<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class ObjectProcessConfiguration
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'ObjectProcessConfiguration')]
final class ObjectProcessConfiguration extends Model
{   
    /**
     * The container that stores allowed features.
     * @var AllowedFeatures|null
     */
    #[XmlElement(rename: 'AllowedFeatures', type: AllowedFeatures::class)]
    public ?AllowedFeatures $allowedFeatures;

    /**
     * The container that stores the transformation configurations.
     * @var TransformationConfigurations|null
     */
    #[XmlElement(rename: 'TransformationConfigurations', type: TransformationConfigurations::class)]
    public ?TransformationConfigurations $transformationConfigurations;

    /**
     * ObjectProcessConfiguration constructor.
     * @param AllowedFeatures|null $allowedFeatures The container that stores allowed features.
     * @param TransformationConfigurations|null $transformationConfigurations The container that stores the transformation configurations.
     */
    public function __construct(
        ?AllowedFeatures $allowedFeatures = null,
        ?TransformationConfigurations $transformationConfigurations = null
    )
    {   
        $this->allowedFeatures = $allowedFeatures;
        $this->transformationConfigurations = $transformationConfigurations;
    }
}