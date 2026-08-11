<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class CnameToken
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'CnameToken')]
final class CnameToken extends Model
{
    /**
     * The name of the bucket to which the CNAME record is mapped.
     * @var string|null
     */
    #[XmlElement(rename: 'Bucket', type: 'string')]
    public ?string $bucket;

    /**
     * The name of the CNAME record that is mapped to the bucket.
     * @var string|null
     */
    #[XmlElement(rename: 'Cname', type: 'string')]
    public ?string $cname;

    /**
     * The CNAME token that is returned by OSS.
     * @var string|null
     */
    #[XmlElement(rename: 'Token', type: 'string')]
    public ?string $token;

    /**
     * The time when the CNAME token expires.
     * @var string|null
     */
    #[XmlElement(rename: 'ExpireTime', type: 'string')]
    public ?string $expireTime;


    /**
     * Indicates whether the CNAME record is a wildcard domain name.
     * @var bool|null
     */
    #[XmlElement(rename: 'Wildcard', type: 'bool')]
    public ?bool $wildcard;

    /**
     * CnameToken constructor.
     * @param string|null $bucket The name of the bucket to which the CNAME record is mapped.
     * @param string|null $cname The name of the CNAME record that is mapped to the bucket.
     * @param string|null $token The CNAME token that is returned by OSS.
     * @param string|null $expireTime The time when the CNAME token expires.
     * @param bool|null $wildcard Indicates whether the CNAME record is a wildcard domain name.
     */
    public function __construct(
        ?string $bucket = null,
        ?string $cname = null,
        ?string $token = null,
        ?string $expireTime = null,
        ?bool   $wildcard = null
    )
    {
        $this->bucket = $bucket;
        $this->cname = $cname;
        $this->token = $token;
        $this->expireTime = $expireTime;
        $this->wildcard = $wildcard;
    }
}