<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class Endpoints
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'Endpoints')]
final class Endpoints extends Model
{
    /**
     * The public endpoint of the access point.
     * @var string|null
     */
    #[XmlElement(rename: 'PublicEndpoint', type: 'string')]
    public ?string $publicEndpoint;

    /**
     * 接入点的内网Endpoint。
     * @var string|null
     */
    #[XmlElement(rename: 'InternalEndpoint', type: 'string')]
    public ?string $internalEndpoint;

    /**
     * Endpoints constructor.
     * @param string|null $publicEndpoint The public endpoint of the access point.
     * @param string|null $internalEndpoint 接入点的内网Endpoint。
     */
    public function __construct(
        ?string $publicEndpoint = null,
        ?string $internalEndpoint = null
    )
    {
        $this->publicEndpoint = $publicEndpoint;
        $this->internalEndpoint = $internalEndpoint;
    }
}