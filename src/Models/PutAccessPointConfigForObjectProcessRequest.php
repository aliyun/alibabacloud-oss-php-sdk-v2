<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;
use AlibabaCloud\Oss\V2\Annotation\RequiredProperty;

/**
 * The request for the PutAccessPointConfigForObjectProcess operation.
 * Class PutAccessPointConfigForObjectProcessRequest
 * @package AlibabaCloud\Oss\V2\Models
 */
final class PutAccessPointConfigForObjectProcessRequest extends RequestModel
{   
    /** 
     * The name of the bucket.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'host', rename: 'bucket', type: 'string')]
    public ?string $bucket;

    /** 
     * The name of the Object FC Access Point. The name of an Object FC Access Point must meet the following requirements:The name cannot exceed 63 characters in length.The name can contain only lowercase letters, digits, and hyphens (-) and cannot start or end with a hyphen (-).The name must be unique in the current region.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-access-point-for-object-process-name', type: 'string')]
    public ?string $accessPointForObjectProcessName;

    /** 
     * The request body.
     * @var PutAccessPointConfigForObjectProcessConfiguration|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'body', rename: 'PutAccessPointConfigForObjectProcessConfiguration', type: 'xml')]
    public ?PutAccessPointConfigForObjectProcessConfiguration $putAccessPointConfigForObjectProcessConfiguration;

    /**
     * PutAccessPointConfigForObjectProcessRequest constructor.
     * @param string|null $bucket The name of the bucket.
     * @param string|null $accessPointForObjectProcessName The name of the Object FC Access Point.
     * @param PutAccessPointConfigForObjectProcessConfiguration|null $putAccessPointConfigForObjectProcessConfiguration The request body.
     * @param array|null $options
     */
    public function __construct( 
        ?string $bucket = null,
        ?string $accessPointForObjectProcessName = null,
        ?PutAccessPointConfigForObjectProcessConfiguration $putAccessPointConfigForObjectProcessConfiguration = null,
        ?array $options = null
    )
    {   
        $this->bucket = $bucket;
        $this->accessPointForObjectProcessName = $accessPointForObjectProcessName;
        $this->putAccessPointConfigForObjectProcessConfiguration = $putAccessPointConfigForObjectProcessConfiguration;
        parent::__construct($options);
    }
}