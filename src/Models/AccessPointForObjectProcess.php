<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class AccessPointForObjectProcess
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'AccessPointForObjectProcess')]
final class AccessPointForObjectProcess extends Model
{   
    /**
     * The name of the Object FC Access Point.
     * @var string|null
     */
    #[XmlElement(rename: 'AccessPointNameForObjectProcess', type: 'string')]
    public ?string $accessPointNameForObjectProcess;
    /**
     * The alias of the Object FC Access Point.
     * @var string|null
     */
    #[XmlElement(rename: 'AccessPointForObjectProcessAlias', type: 'string')]
    public ?string $accessPointForObjectProcessAlias;
    /**
     * The name of the access point.
     * @var string|null
     */
    #[XmlElement(rename: 'AccessPointName', type: 'string')]
    public ?string $accessPointName;
    /**
     * The status of the Object FC Access Point. Valid values:enable: The Object FC Access Point is created.disable: The Object FC Access Point is disabled.creating: The Object FC Access Point is being created.deleting: The Object FC Access Point is deleted.
     * @var string|null
     */
    #[XmlElement(rename: 'Status', type: 'string')]
    public ?string $status;
    /**
     * Whether allow anonymous user access this FC Access Point.
     * @var string|null
     */
    #[XmlElement(rename: 'AllowAnonymousAccessForObjectProcess', type: 'string')]
    public ?string $allowAnonymousAccessForObjectProcess;

    /**
     * AccessPointForObjectProcess constructor.
     * @param string|null $accessPointNameForObjectProcess The name of the Object FC Access Point.
     * @param string|null $accessPointForObjectProcessAlias The alias of the Object FC Access Point.
     * @param string|null $accessPointName The name of the access point.
     * @param string|null $status The status of the Object FC Access Point.
     * @param string|null $allowAnonymousAccessForObjectProcess Whether allow anonymous user access this FC Access Point.
     */
    public function __construct(
        ?string $accessPointNameForObjectProcess = null,
        ?string $accessPointForObjectProcessAlias = null,
        ?string $accessPointName = null,
        ?string $status = null,
        ?string $allowAnonymousAccessForObjectProcess = null
    )
    {   
        $this->accessPointNameForObjectProcess = $accessPointNameForObjectProcess;
        $this->accessPointForObjectProcessAlias = $accessPointForObjectProcessAlias;
        $this->accessPointName = $accessPointName;
        $this->status = $status;
        $this->allowAnonymousAccessForObjectProcess = $allowAnonymousAccessForObjectProcess;
    }
}