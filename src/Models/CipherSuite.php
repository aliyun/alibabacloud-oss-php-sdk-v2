<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class CipherSuite
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'CipherSuite')]
final class CipherSuite extends Model
{
    /**
     * Specifies whether to enable the cipher suite configuration.
     * @var bool|null
     */
    #[XmlElement(rename: 'Enable', type: 'bool')]
    public ?bool $enable;

    /**
     * Specifies whether to use the strong cipher suite.
     * @var bool|null
     */
    #[XmlElement(rename: 'StrongCipherSuite', type: 'bool')]
    public ?bool $strongCipherSuite;

    /**
     * The custom cipher suites.
     * @var array<string>|null
     */
    #[XmlElement(rename: 'CustomCipherSuite', type: 'string')]
    public ?array $customCipherSuites;

    /**
     * The custom cipher suites for TLS 1.3.
     * @var array<string>|null
     */
    #[XmlElement(rename: 'TLS13CustomCipherSuite', type: 'string')]
    public ?array $tls13CustomCipherSuites;

    /**
     * CipherSuite constructor.
     * @param bool|null $enable
     * @param bool|null $strongCipherSuite
     * @param array<string>|null $customCipherSuites
     * @param array<string>|null $tls13CustomCipherSuites
     */
    public function __construct(
        ?bool $enable = null,
        ?bool $strongCipherSuite = null,
        ?array $customCipherSuites = null,
        ?array $tls13CustomCipherSuites = null
    )
    {
        $this->enable = $enable;
        $this->strongCipherSuite = $strongCipherSuite;
        $this->customCipherSuites = $customCipherSuites;
        $this->tls13CustomCipherSuites = $tls13CustomCipherSuites;
    }
}