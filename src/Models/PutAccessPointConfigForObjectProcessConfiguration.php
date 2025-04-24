<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class PutAccessPointConfigForObjectProcessConfiguration
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'PutAccessPointConfigForObjectProcessConfiguration')]
final class PutAccessPointConfigForObjectProcessConfiguration extends Model
{
    /**
     * Whether allow anonymous user to access this FC Access Point.
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
     * The container that stores the processing information about the Object FC Access Point.
     * @var ObjectProcessConfiguration|null
     */
    #[XmlElement(rename: 'ObjectProcessConfiguration', type: ObjectProcessConfiguration::class)]
    public ?ObjectProcessConfiguration $objectProcessConfiguration;

    /**
     * PutAccessPointConfigForObjectProcessConfiguration constructor.
     * @param string|null $allowAnonymousAccessForObjectProcess Whether allow anonymous user to access this FC Access Point.
     * @param PublicAccessBlockConfiguration|null $publicAccessBlockConfiguration The container in which the Block Public Access configurations are stored.
     * @param ObjectProcessConfiguration|null $objectProcessConfiguration The container that stores the processing information about the Object FC Access Point.
     */
    public function __construct(
        ?string $allowAnonymousAccessForObjectProcess = null,
        ?PublicAccessBlockConfiguration $publicAccessBlockConfiguration = null,
        ?ObjectProcessConfiguration $objectProcessConfiguration = null
    )
    {
        $this->allowAnonymousAccessForObjectProcess = $allowAnonymousAccessForObjectProcess;
        $this->publicAccessBlockConfiguration = $publicAccessBlockConfiguration;
        $this->objectProcessConfiguration = $objectProcessConfiguration;
    }
}