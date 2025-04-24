<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;
use AlibabaCloud\Oss\V2\Annotation\RequiredProperty;

/**
 * The request for the PutAccessPointPolicyForObjectProcess operation.
 * Class PutAccessPointPolicyForObjectProcessRequest
 * @package AlibabaCloud\Oss\V2\Models
 */
final class PutAccessPointPolicyForObjectProcessRequest extends RequestModel
{
    /**
     * The name of the bucket.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'host', rename: 'bucket', type: 'string')]
    public ?string $bucket;

    /**
     * The name of the Object FC Access Point.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-access-point-for-object-process-name', type: 'string')]
    public ?string $accessPointForObjectProcessName;

    /**
     * The json format permission policies for an Object FC Access Point.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'body', rename: 'nop', type: 'string')]
    public ?string $body;

    /**
     * PutAccessPointPolicyForObjectProcessRequest constructor.
     * @param string|null $bucket The name of the bucket.
     * @param string|null $accessPointForObjectProcessName The name of the Object FC Access Point.
     * @param string|null $body The json format permission policies for an Object FC Access Point.
     * @param array|null $options
     */
    public function __construct(
        ?string $bucket = null,
        ?string $accessPointForObjectProcessName = null,
        ?string $body = null,
        ?array $options = null
    )
    {
        $this->bucket = $bucket;
        $this->accessPointForObjectProcessName = $accessPointForObjectProcessName;
        $this->body = $body;
        parent::__construct($options);
    }
}