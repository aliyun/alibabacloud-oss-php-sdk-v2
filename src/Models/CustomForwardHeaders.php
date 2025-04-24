<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class CustomForwardHeaders
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'CustomForwardHeaders')]
final class CustomForwardHeaders extends Model
{   
    /**
     * @var array<string>|null
     */
    #[XmlElement(rename: 'CustomForwardHeader', type: 'string')]
    public ?array $customForwardHeaders;

    /**
     * CustomForwardHeaders constructor.
     * @param array<string>|null $customForwardHeaders
     */
    public function __construct(
        ?array $customForwardHeaders = null
    )
    {   
        $this->customForwardHeaders = $customForwardHeaders;
    }
}