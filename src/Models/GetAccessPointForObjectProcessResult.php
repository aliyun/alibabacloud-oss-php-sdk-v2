<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;

/**
 * The result for the GetAccessPointForObjectProcessResult operation.
 * Class GetAccessPointForObjectProcessResult
 * @package AlibabaCloud\Oss\V2\Models
 */
final class GetAccessPointForObjectProcessResult extends ResultModel
{
    /**
     * The public endpoint of the Object FC Access Point.
     * @var string|null
     */
    #[XmlElement(rename: 'AccountId', type: 'string')]
    public ?string $accountId;

    /**
     * The public endpoint of the Object FC Access Point.
     * @var string|null
     */
    #[XmlElement(rename: 'AccessPointForObjectProcessArn', type: 'string')]
    public ?string $accessPointForObjectProcessArn;

    /**
     * The time when the Object FC Access Point was created. The value is a timestamp.
     * @var string|null
     */
    #[XmlElement(rename: 'CreationDate', type: 'string')]
    public ?string $creationDate;

    /**
     * The status of the Object FC Access Point. Valid values:enable: The Object FC Access Point is created.disable: The Object FC Access Point is disabled.creating: The Object FC Access Point is being created.deleting: The Object FC Access Point is deleted.
     * @var string|null
     */
    #[XmlElement(rename: 'Status', type: 'string')]
    public ?string $accessPointForObjectProcessStatus;

    /**
     * The public endpoint of the Object FC Access Point.
     * @var string|null
     */
    #[XmlElement(rename: 'AccessPointName', type: 'string')]
    public ?string $accessPointName;

    /**
     * The name of the Object FC Access Point.
     * @var string|null
     */
    #[XmlElement(rename: 'AccessPointNameForObjectProcess', type: 'string')]
    public ?string $accessPointNameForObjectProcess;

    /**
     * The public endpoint of the Object FC Access Point.
     * @var string|null
     */
    #[XmlElement(rename: 'AccessPointForObjectProcessAlias', type: 'string')]
    public ?string $accessPointForObjectProcessAlias;

    /**
     * The container that stores the endpoints of the Object FC Access Point.
     * @var AccessPointEndpoints|null
     */
    #[XmlElement(rename: 'Endpoints', type: AccessPointEndpoints::class, format: 'xml')]
    public ?AccessPointEndpoints $endpoints;

    /**
     * Whether allow anonymous users to access this FC Access Point.
     * @var string|null
     */
    #[XmlElement(rename: 'AllowAnonymousAccessForObjectProcess', type: 'string')]
    public ?string $allowAnonymousAccessForObjectProcess;

    /**
     * The public endpoint of the Object FC Access Point.
     * @var PublicAccessBlockConfiguration|null
     */
    #[XmlElement(rename: 'PublicAccessBlockConfiguration', type: PublicAccessBlockConfiguration::class)]
    public ?PublicAccessBlockConfiguration $publicAccessBlockConfiguration;

    /**
     * GetAccessPointForObjectProcessResult constructor.
     * @param string|null $accessPointName The name of the access point.
     * @param string|null $accountId The public endpoint of the Object FC Access Point.
     * @param string|null $accessPointForObjectProcessArn The public endpoint of the Object FC Access Point.
     * @param string|null $creationDate The time when the Object FC Access Point was created.
     * @param string|null $accessPointForObjectProcessStatus The status of the Object FC Access Point.
     * @param string|null $accessPointNameForObjectProcess The name of the Object FC Access Point.
     * @param string|null $accessPointForObjectProcessAlias The public endpoint of the Object FC Access Point.
     * @param AccessPointEndpoints|null $endpoints The container that stores the endpoints of the Object FC Access Point.
     * @param string|null $allowAnonymousAccessForObjectProcess Whether allow anonymous users to access this FC Access Point.
     * @param PublicAccessBlockConfiguration|null $publicAccessBlockConfiguration The public endpoint of the Object FC Access Point.
     */
    public function __construct(
        ?string $accessPointName = null,
        ?string $accountId = null,
        ?string $accessPointForObjectProcessArn = null,
        ?string $creationDate = null,
        ?string $accessPointForObjectProcessStatus = null,
        ?string $accessPointNameForObjectProcess = null,
        ?string $accessPointForObjectProcessAlias = null,
        ?AccessPointEndpoints $endpoints = null,
        ?string $allowAnonymousAccessForObjectProcess = null,
        ?PublicAccessBlockConfiguration $publicAccessBlockConfiguration = null
    )
    {
        $this->accessPointName = $accessPointName;
        $this->accountId = $accountId;
        $this->accessPointForObjectProcessArn = $accessPointForObjectProcessArn;
        $this->creationDate = $creationDate;
        $this->accessPointForObjectProcessStatus = $accessPointForObjectProcessStatus;
        $this->accessPointNameForObjectProcess = $accessPointNameForObjectProcess;
        $this->accessPointForObjectProcessAlias = $accessPointForObjectProcessAlias;
        $this->endpoints = $endpoints;
        $this->allowAnonymousAccessForObjectProcess = $allowAnonymousAccessForObjectProcess;
        $this->publicAccessBlockConfiguration = $publicAccessBlockConfiguration;
    }
}