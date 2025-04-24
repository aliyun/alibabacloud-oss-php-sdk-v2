<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class ContentTransformation
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'ContentTransformation')]
final class ContentTransformation extends Model
{   
    /**
     * The container that stores the information about Function Compute.
     * @var FunctionCompute|null
     */
    #[XmlElement(rename: 'FunctionCompute', type: FunctionCompute::class)]
    public ?FunctionCompute $functionCompute;
    /**
     * @var AdditionalFeatures|null
     */
    #[XmlElement(rename: 'AdditionalFeatures', type: AdditionalFeatures::class)]
    public ?AdditionalFeatures $additionalFeatures;

    /**
     * ContentTransformation constructor.
     * @param FunctionCompute|null $functionCompute The container that stores the information about Function Compute.
     * @param AdditionalFeatures|null $additionalFeatures
     */
    public function __construct(
        ?FunctionCompute $functionCompute = null,
        ?AdditionalFeatures $additionalFeatures = null
    )
    {   
        $this->functionCompute = $functionCompute;
        $this->additionalFeatures = $additionalFeatures;
    }
}