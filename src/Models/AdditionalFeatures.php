<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class AdditionalFeatures
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'AdditionalFeatures')]
final class AdditionalFeatures extends Model
{   
    /**
     * @var CustomForwardHeaders|null
     */
    #[XmlElement(rename: 'CustomForwardHeaders', type: CustomForwardHeaders::class)]
    public ?CustomForwardHeaders $customForwardHeaders;

    /**
     * AdditionalFeatures constructor.
     * @param CustomForwardHeaders|null $customForwardHeaders
     */
    public function __construct(
        ?CustomForwardHeaders $customForwardHeaders = null
    )
    {   
        $this->customForwardHeaders = $customForwardHeaders;
    }
}