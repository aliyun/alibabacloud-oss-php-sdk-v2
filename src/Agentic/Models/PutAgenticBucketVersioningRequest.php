<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;
use AlibabaCloud\Oss\V2\Annotation\RequiredProperty;
use AlibabaCloud\Oss\V2\Models\VersioningConfiguration;

/**
 * The request for the PutAgenticBucketVersioning operation.
 * Class PutAgenticBucketVersioningRequest
 * @package AlibabaCloud\Oss\V2\Agentic\Models
 */
final class PutAgenticBucketVersioningRequest extends RequestModel
{
    /**
     * The name of the bucket.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'host', rename: 'bucket', type: 'string')]
    public ?string $bucket;

    /**
     * The request body schema.
     * @var VersioningConfiguration|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'body', rename: 'VersioningConfiguration', type: 'xml')]
    public ?VersioningConfiguration $versioningConfiguration;

    /**
     * PutAgenticBucketVersioningRequest constructor.
     * @param string|null $bucket The name of the bucket.
     * @param VersioningConfiguration|null $versioningConfiguration The request body schema.
     * @param array|null $options
     */
    public function __construct(
        ?string $bucket = null,
        ?VersioningConfiguration $versioningConfiguration = null,
        ?array $options = null
    )
    {
        $this->bucket = $bucket;
        $this->versioningConfiguration = $versioningConfiguration;
        parent::__construct($options);
    }
}
