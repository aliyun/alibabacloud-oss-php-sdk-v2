<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;
use AlibabaCloud\Oss\V2\Annotation\TagBody;

/**
 * The result for the GetAgenticBucket operation.
 * Class GetAgenticBucketResult
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class GetAgenticBucketResult extends ResultModel
{
    /**
     * The container that stores the agentic bucket information.
     * @var AgenticBucketInfo|null
     */
    #[TagBody(rename: 'AgenticBucketInfo', type: AgenticBucketInfo::class, format: 'xml')]
    public ?AgenticBucketInfo $agenticBucketInfo;

    /**
     * GetAgenticBucketResult constructor.
     * @param AgenticBucketInfo|null $agenticBucketInfo The container that stores the agentic bucket information.
     */
    public function __construct(
        ?AgenticBucketInfo $agenticBucketInfo = null
    )
    {
        $this->agenticBucketInfo = $agenticBucketInfo;
    }
}
