<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class CreateAccessPointForObjectProcessConfiguration
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'CreateAccessPointForObjectProcessConfiguration')]
final class CreateAccessPointForObjectProcessConfiguration extends Model
{
    /**
     * Whether allow anonymous user to access this FC Access Point.
     * @var string|null
     */
    #[XmlElement(rename: 'AllowAnonymousAccessForObjectProcess', type: 'string')]
    public ?string $allowAnonymousAccessForObjectProcess;

    /**
     * The name of the access point.
     * @var string|null
     */
    #[XmlElement(rename: 'AccessPointName', type: 'string')]
    public ?string $accessPointName;

    /**
     * The container that stores the processing information about the Object FC Access Point.
     * @var ObjectProcessConfiguration|null
     */
    #[XmlElement(rename: 'ObjectProcessConfiguration', type: ObjectProcessConfiguration::class)]
    public ?ObjectProcessConfiguration $objectProcessConfiguration;

    /**
     * CreateAccessPointForObjectProcessConfiguration constructor.
     * @param string|null $allowAnonymousAccessForObjectProcess Whether allow anonymous user to access this FC Access Point.
     * @param string|null $accessPointName The name of the access point.
     * @param ObjectProcessConfiguration|null $objectProcessConfiguration The container that stores the processing information about the Object FC Access Point.
     */
    public function __construct(
        ?string $allowAnonymousAccessForObjectProcess = null,
        ?string $accessPointName = null,
        ?ObjectProcessConfiguration $objectProcessConfiguration = null
    )
    {
        $this->allowAnonymousAccessForObjectProcess = $allowAnonymousAccessForObjectProcess;
        $this->accessPointName = $accessPointName;
        $this->objectProcessConfiguration = $objectProcessConfiguration;
    }
}