<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;

/**
 * The result for the GetAccessPointConfigForObjectProcess operation.
 * Class GetAccessPointConfigForObjectProcessResult
 * @package AlibabaCloud\Oss\V2\Models
 */
final class GetAccessPointConfigForObjectProcessResult extends ResultModel
{   
    /**
     * The container that stores the processing information about the Object FC Access Point.
     * @var ObjectProcessConfiguration|null
     */
    #[XmlElement(rename: 'ObjectProcessConfiguration', type: ObjectProcessConfiguration::class)]
    public ?ObjectProcessConfiguration $objectProcessConfiguration;

    /** 
     * Whether allow anonymous user to access this FC Access Points.
     * @var string|null
     */
    #[XmlElement(rename: 'AllowAnonymousAccessForObjectProcess', type: 'string')]
    public ?string $allowAnonymousAccessForObjectProcess;

    /** 
     * The container in which the Block Public Access configurations are stored.
     * @var PublicAccessBlockConfiguration|null
     */
    #[XmlElement(rename: 'PublicAccessBlockConfiguration', type: PublicAccessBlockConfiguration::class)]
    public ?PublicAccessBlockConfiguration $publicAccessBlockConfiguration;

    /**
     * GetAccessPointConfigForObjectProcessRequest constructor.
     * @param ObjectProcessConfiguration|null $objectProcessConfiguration The container that stores the processing information about the Object FC Access Point.
     * @param string|null $allowAnonymousAccessForObjectProcess Whether allow anonymous user to access this FC Access Points.
     * @param PublicAccessBlockConfiguration|null $publicAccessBlockConfiguration The container in which the Block Public Access configurations are stored.
     */
    public function __construct(
        ?ObjectProcessConfiguration $objectProcessConfiguration = null,
        ?string $allowAnonymousAccessForObjectProcess = null,
        ?PublicAccessBlockConfiguration $publicAccessBlockConfiguration = null
    )
    {   
        $this->objectProcessConfiguration = $objectProcessConfiguration;
        $this->allowAnonymousAccessForObjectProcess = $allowAnonymousAccessForObjectProcess;
        $this->publicAccessBlockConfiguration = $publicAccessBlockConfiguration;
    }
}