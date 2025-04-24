<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class AllowedFeatures
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'AllowedFeatures')]
final class AllowedFeatures extends Model
{   
    /**
     * Specifies that Function Compute supports Range GetObject requests.
     * @var array<string>|null
     */
    #[XmlElement(rename: 'AllowedFeature', type: 'string')]
    public ?array $allowedFeatures;

    /**
     * AllowedFeatures constructor.
     * @param array<string>|null $allowedFeatures Specifies that Function Compute supports Range GetObject requests.
     */
    public function __construct(
        ?array $allowedFeatures = null
    )
    {   
        $this->allowedFeatures = $allowedFeatures;
    }
}