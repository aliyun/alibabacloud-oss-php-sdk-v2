<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;
use AlibabaCloud\Oss\V2\Annotation\TagBody;
use AlibabaCloud\Oss\V2\Models\PublicAccessBlockConfiguration;

/**
 * The result for the GetAgenticBucketPublicAccessBlock operation.
 * Class GetAgenticBucketPublicAccessBlockResult
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class GetAgenticBucketPublicAccessBlockResult extends ResultModel
{
    /**
     * The container that stores the public access block configuration.
     * @var PublicAccessBlockConfiguration|null
     */
    #[TagBody(rename: 'PublicAccessBlockConfiguration', type: PublicAccessBlockConfiguration::class, format: 'xml')]
    public ?PublicAccessBlockConfiguration $publicAccessBlockConfiguration;

    /**
     * GetAgenticBucketPublicAccessBlockResult constructor.
     * @param PublicAccessBlockConfiguration|null $publicAccessBlockConfiguration The container that stores the public access block configuration.
     */
    public function __construct(
        ?PublicAccessBlockConfiguration $publicAccessBlockConfiguration = null
    )
    {
        $this->publicAccessBlockConfiguration = $publicAccessBlockConfiguration;
    }
}
