<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * The result for the CreateAccessPointForObjectProcess operation.
 * Class CreateAccessPointForObjectProcessResult
 * @package AlibabaCloud\Oss\V2\Models
 */
final class CreateAccessPointForObjectProcessResult extends ResultModel
{   
    /**
     * The ARN of the Object FC Access Point.
     * @var string|null
     */
    #[XmlElement(rename: 'AccessPointForObjectProcessArn', type: 'string')]
    public ?string $accessPointForObjectProcessArn;

    /** 
     * The alias of the Object FC Access Point.
     * @var string|null
     */
    #[XmlElement(rename: 'AccessPointForObjectProcessAlias', type: 'string')]
    public ?string $accessPointForObjectProcessAlias;

    /**
     * CreateAccessPointForObjectProcessRequest constructor.
     * @param string|null $accessPointForObjectProcessArn The ARN of the Object FC Access Point.
     * @param string|null $accessPointForObjectProcessAlias The alias of the Object FC Access Point.
     */
    public function __construct(
        ?string $accessPointForObjectProcessArn = null,
        ?string $accessPointForObjectProcessAlias = null
    )
    {   
        $this->accessPointForObjectProcessArn = $accessPointForObjectProcessArn;
        $this->accessPointForObjectProcessAlias = $accessPointForObjectProcessAlias;
    }
}