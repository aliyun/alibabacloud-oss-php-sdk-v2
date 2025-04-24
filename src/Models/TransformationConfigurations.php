<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class TransformationConfigurations
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'TransformationConfigurations')]
final class TransformationConfigurations extends Model
{   
    /**
     * The container that stores the transformation configurations.
     * @var array<TransformationConfiguration>|null
     */
    #[XmlElement(rename: 'TransformationConfiguration', type: TransformationConfiguration::class)]
    public ?array $transformationConfigurations;

    /**
     * TransformationConfigurations constructor.
     * @param array<TransformationConfiguration>|null $transformationConfigurations The container that stores the transformation configurations.
     */
    public function __construct(
        ?array $transformationConfigurations = null
    )
    {   
        $this->transformationConfigurations = $transformationConfigurations;
    }
}