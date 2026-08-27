<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class Cname
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'Cname')]
final class Cname extends Model
{
    /**
     * The custom domain name.
     * @var string|null
     */
    #[XmlElement(rename: 'Domain', type: 'string')]
    public ?string $domain;

    /**
     * The container for which the certificate is configured.
     * @var CertificateConfiguration|null
     */
    #[XmlElement(rename: 'CertificateConfiguration', type: CertificateConfiguration::class)]
    public ?CertificateConfiguration $certificateConfiguration;


    /**
     * Indicates whether the custom domain name is a wildcard domain name.
     * @var bool|null
     */
    #[XmlElement(rename: 'IsWildCard', type: 'bool')]
    public ?bool $isWildCard;

    /**
     * Cname constructor.
     * @param string|null $domain The custom domain name.
     * @param CertificateConfiguration|null $certificateConfiguration The container for which the certificate is configured.
     * @param bool|null $isWildCard Indicates whether the custom domain name is a wildcard domain name.
     */
    public function __construct(
        ?string $domain = null,
        ?CertificateConfiguration $certificateConfiguration = null,
        ?bool $isWildCard = null
    )
    {
        $this->domain = $domain;
        $this->certificateConfiguration = $certificateConfiguration;
        $this->isWildCard = $isWildCard;
    }
}