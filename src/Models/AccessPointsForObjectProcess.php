<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class AccessPointsForObjectProcess
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'AccessPointsForObjectProcess')]
final class AccessPointsForObjectProcess extends Model
{   
    /**
     * The container that stores information about a single Object FC Access Point.
     * @var array<AccessPointForObjectProcess>|null
     */
    #[XmlElement(rename: 'AccessPointForObjectProcess', type: AccessPointForObjectProcess::class)]
    public ?array $accessPointForObjectProcesss;

    /**
     * AccessPointsForObjectProcess constructor.
     * @param array<AccessPointForObjectProcess>|null $accessPointForObjectProcesss The container that stores information about a single Object FC Access Point.
     */
    public function __construct(
        ?array $accessPointForObjectProcesss = null
    )
    {   
        $this->accessPointForObjectProcesss = $accessPointForObjectProcesss;
    }
}