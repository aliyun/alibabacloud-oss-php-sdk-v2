<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;

/**
 * The result for the GetAgenticBucketPolicy operation.
 * Class GetAgenticBucketPolicyResult
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class GetAgenticBucketPolicyResult extends ResultModel
{
    /**
     * The policy document, as a JSON string.
     * @var string|null
     */
    public ?string $policy;

    /**
     * GetAgenticBucketPolicyResult constructor.
     * @param string|null $policy The policy document, as a JSON string.
     */
    public function __construct(
        ?string $policy = null
    )
    {
        $this->policy = $policy;
    }
}
