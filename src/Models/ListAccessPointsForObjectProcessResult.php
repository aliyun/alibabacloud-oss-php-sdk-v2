<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;

/**
 * The result for the ListAccessPointsForObjectProcess operation.
 * Class ListAccessPointsForObjectProcessResult
 * @package AlibabaCloud\Oss\V2\Models
 */
final class ListAccessPointsForObjectProcessResult extends ResultModel
{

    /**
     * The container that stores information about a single Object FC Access Point.
     * @var bool|null
     */
    #[XmlElement(rename: 'IsTruncated', type: 'bool')]
    public ?bool $isTruncated;

    /**
     * Indicates that this ListAccessPointsForObjectProcess request contains subsequent results. You need to set the NextContinuationToken element to continuation-token for subsequent results.
     * @var string|null
     */
    #[XmlElement(rename: 'NextContinuationToken', type: 'string')]
    public ?string $nextContinuationToken;

    /**
     * The UID of the Alibaba Cloud account to which the Object FC Access Points belong.
     * @var string|null
     */
    #[XmlElement(rename: 'AccountId', type: 'string')]
    public ?string $accountId;

    /**
     * @var AccessPointsForObjectProcess|null
     */
    #[XmlElement(rename: 'AccessPointsForObjectProcess', type: AccessPointsForObjectProcess::class, format: 'xml')]
    public ?AccessPointsForObjectProcess $accessPointsForObjectProcess;

    /**
     * ListAccessPointsForObjectProcessRequest constructor.
     * @param bool|null $isTruncated The container that stores information about a single Object FC Access Point.
     * @param string|null $nextContinuationToken Indicates that this ListAccessPointsForObjectProcess request contains subsequent results.
     * @param string|null $accountId The UID of the Alibaba Cloud account to which the Object FC Access Points belong.
     * @param AccessPointsForObjectProcess|null $accessPointsForObjectProcess
     */
    public function __construct(
        ?bool $isTruncated = null,
        ?string $nextContinuationToken = null,
        ?string $accountId = null,
        ?AccessPointsForObjectProcess $accessPointsForObjectProcess = null
    )
    {
        $this->isTruncated = $isTruncated;
        $this->nextContinuationToken = $nextContinuationToken;
        $this->accountId = $accountId;
        $this->accessPointsForObjectProcess = $accessPointsForObjectProcess;
    }
}