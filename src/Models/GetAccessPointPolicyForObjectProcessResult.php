<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;

/**
 * The result for the GetAccessPointPolicyForObjectProcess operation.
 * Class GetAccessPointPolicyForObjectProcessResult
 * @package AlibabaCloud\Oss\V2\Models
 */
final class GetAccessPointPolicyForObjectProcessResult extends ResultModel
{
    /**
     * @var string|null
     */
    public ?string $body;

    /**
     * GetAccessPointPolicyForObjectProcessRequest constructor.
     * @param string|null $body
     */
    public function __construct(
        ?string $body = null
    )
    {
        $this->body = $body;
    }
}