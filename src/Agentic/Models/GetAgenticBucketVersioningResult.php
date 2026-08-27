<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;
use AlibabaCloud\Oss\V2\Annotation\TagBody;
use AlibabaCloud\Oss\V2\Models\VersioningConfiguration;

/**
 * The result for the GetAgenticBucketVersioning operation.
 * Class GetAgenticBucketVersioningResult
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class GetAgenticBucketVersioningResult extends ResultModel
{
    /**
     * The container that stores the versioning state of the bucket.
     * @var VersioningConfiguration|null
     */
    #[TagBody(rename: 'VersioningConfiguration', type: VersioningConfiguration::class, format: 'xml')]
    public ?VersioningConfiguration $versioningConfiguration;

    /**
     * GetAgenticBucketVersioningResult constructor.
     * @param VersioningConfiguration|null $versioningConfiguration The container that stores the versioning state of the bucket.
     */
    public function __construct(
        ?VersioningConfiguration $versioningConfiguration = null
    )
    {
        $this->versioningConfiguration = $versioningConfiguration;
    }
}
