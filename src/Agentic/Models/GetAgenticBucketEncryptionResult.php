<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;
use AlibabaCloud\Oss\V2\Annotation\TagBody;
use AlibabaCloud\Oss\V2\Models\ServerSideEncryptionRule;

/**
 * The result for the GetAgenticBucketEncryption operation.
 * Class GetAgenticBucketEncryptionResult
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class GetAgenticBucketEncryptionResult extends ResultModel
{
    /**
     * The container that stores server-side encryption rules.
     * @var ServerSideEncryptionRule|null
     */
    #[TagBody(rename: 'ServerSideEncryptionRule', type: ServerSideEncryptionRule::class, format: 'xml')]
    public ?ServerSideEncryptionRule $serverSideEncryptionRule;

    /**
     * GetAgenticBucketEncryptionResult constructor.
     * @param ServerSideEncryptionRule|null $serverSideEncryptionRule The container that stores server-side encryption rules.
     */
    public function __construct(
        ?ServerSideEncryptionRule $serverSideEncryptionRule = null
    )
    {
        $this->serverSideEncryptionRule = $serverSideEncryptionRule;
    }
}
