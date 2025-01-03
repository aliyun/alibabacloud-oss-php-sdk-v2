<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;
use AlibabaCloud\Oss\V2\Annotation\RequiredProperty;

/**
 * The request for the CompleteBucketWorm operation.
 * Class CompleteBucketWormRequest
 * @package AlibabaCloud\Oss\V2\Models
 */
final class CompleteBucketWormRequest extends RequestModel
{
    /**
     * The name of the bucket.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'host', rename: 'bucket', type: 'string')]
    public ?string $bucket;

    /**
     * The ID of the retention policy.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'query', rename: 'wormId', type: 'string')]
    public ?string $wormId;

    /**
     * CompleteBucketWormRequest constructor.
     * @param string|null $bucket The name of the bucket.
     * @param string|null $wormId The ID of the retention policy.
     * @param array|null $options
     */
    public function __construct(
        ?string $bucket = null,
        ?string $wormId = null,
        ?array $options = null
    )
    {
        $this->bucket = $bucket;
        $this->wormId = $wormId;
        parent::__construct($options);
    }
}