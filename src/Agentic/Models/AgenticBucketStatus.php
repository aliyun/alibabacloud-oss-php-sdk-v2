<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class AgenticBucketStatus
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
#[XmlRoot(name: 'AgenticBucketStatus')]
final class AgenticBucketStatus extends Model
{
    /**
     * The status of the agentic bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'Status', type: 'string')]
    public ?string $status;

    /**
     * AgenticBucketStatus constructor.
     * @param string|null $status The status of the agentic bucket.
     */
    public function __construct(
        ?string $status = null
    )
    {
        $this->status = $status;
    }
}
