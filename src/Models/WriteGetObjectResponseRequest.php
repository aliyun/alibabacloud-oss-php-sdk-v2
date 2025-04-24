<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;
use AlibabaCloud\Oss\V2\Annotation\RequiredProperty;

/**
 * The request for the WriteGetObjectResponseRequest operation.
 * Class GetAccessPointConfigForObjectProcessRequest
 * @package AlibabaCloud\Oss\V2\Models
 */
final class WriteGetObjectResponseRequest extends RequestModel
{
    /**
     * The router forwarding address obtained from the event parameter of Function Compute.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-request-route', type: 'string')]
    public ?string $requestRoute;

    /**
     * The unique forwarding token obtained from the event parameter of Function Compute.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-request-token', type: 'string')]
    public ?string $requestToken;

    /**
     * The HTTP status code returned by the backend server.
     * @var string|null
     */
    #[RequiredProperty()]
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-fwd-status', type: 'string')]
    public ?string $fwdStatus;

    /**
     * The HTTP response header returned by the backend server. It is used to specify the scope of the resources that you want to query.
     * @var string|null
     */
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-fwd-header-Accept-Ranges', type: 'string')]
    public ?string $fwdHeaderAcceptRanges;

    /**
     * The HTTP response header returned by the backend server. It is used to specify the resource cache method that the client uses. Valid values: no-cache, no-store, public, private, max-age
     * @var string|null
     */
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-fwd-header-Cache-Control', type: 'string')]
    public ?string $fwdHeaderCacheControl;

    /**
     * @var string|null
     */
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-fwd-header-Content-Disposition', type: 'string')]
    public ?string $fwdHeaderContentDisposition;

    /**
     * @var string|null
     */
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-fwd-header-Content-Encoding', type: 'string')]
    public ?string $fwdHeaderContentEncoding;

    /**
     * @var string|null
     */
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-fwd-header-Content-Language', type: 'string')]
    public ?string $fwdHeaderContentLanguage;

    /**
     * @var string|null
     */
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-fwd-header-Content-Range', type: 'string')]
    public ?string $fwdHeaderContentRange;

    /**
     * The HTTP response header returned by the backend server. It is used to specify the type of the received or sent data.
     * @var string|null
     */
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-fwd-header-Content-Type', type: 'string')]
    public ?string $fwdHeaderContentType;

    /**
     * The HTTP response header returned by the backend server. It uniquely identifies the object.
     * @var string|null
     */
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-fwd-header-Etag', type: 'string')]
    public ?string $fwdHeaderEtag;

    /**
     * The HTTP response header returned by the backend server. It specifies the absolute expiration time of the cache.
     * @var string|null
     */
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-fwd-header-Expires', type: 'string')]
    public ?string $fwdHeaderExpires;

    /**
     * The HTTP response header returned by the backend server. It specifies the time when the requested resource was last modified.
     * @var string|null
     */
    #[TagProperty(tag: '', position: 'header', rename: 'x-oss-fwd-header-Last-Modified', type: 'string')]
    public ?string $fwdHeaderLastModified;

    /**
     * @var \Psr\Http\Message\StreamInterface|null
     */
    public ?\Psr\Http\Message\StreamInterface $body;

    /**
     * WriteGetObjectResponseRequest constructor.
     * @param string|null $requestRoute The router forwarding address obtained from the event parameter of Function Compute.
     * @param string|null $requestToken The unique forwarding token obtained from the event parameter of Function Compute.
     * @param string|null $fwdStatus The HTTP status code returned by the backend server.
     * @param string|null $fwdHeaderAcceptRanges The HTTP response header returned by the backend server. It is used to specify the scope of the resources that you want to query.
     * @param string|null $fwdHeaderCacheControl The HTTP response header returned by the backend server. It is used to specify the resource cache method that the client uses. Valid values: no-cache, no-store, public, private, max-age
     * @param string|null $fwdHeaderContentDisposition
     * @param string|null $fwdHeaderContentEncoding
     * @param string|null $fwdHeaderContentLanguage
     * @param string|null $fwdHeaderContentRange
     * @param string|null $fwdHeaderContentType The HTTP response header returned by the backend server. It is used to specify the type of the received or sent data.
     * @param string|null $fwdHeaderEtag The HTTP response header returned by the backend server. It uniquely identifies the object.
     * @param string|null $fwdHeaderExpires The HTTP response header returned by the backend server. It specifies the absolute expiration time of the cache.
     * @param string|null $fwdHeaderLastModified The HTTP response header returned by the backend server. It specifies the time when the requested resource was last modified.
     * @param \Psr\Http\Message\StreamInterface|null $body
     * @param array|null $options
     */
    public function __construct(
        ?string $requestRoute = null,
        ?string $requestToken = null,
        ?string $fwdStatus = null,
        ?string $fwdHeaderAcceptRanges = null,
        ?string $fwdHeaderCacheControl = null,
        ?string $fwdHeaderContentDisposition = null,
        ?string $fwdHeaderContentEncoding = null,
        ?string $fwdHeaderContentLanguage = null,
        ?string $fwdHeaderContentRange = null,
        ?string $fwdHeaderContentType = null,
        ?string $fwdHeaderEtag = null,
        ?string $fwdHeaderExpires = null,
        ?string $fwdHeaderLastModified = null,
        ?\Psr\Http\Message\StreamInterface $body = null,
        ?array $options = null
    )
    {
        $this->requestRoute = $requestRoute;
        $this->requestToken = $requestToken;
        $this->fwdStatus = $fwdStatus;
        $this->fwdHeaderAcceptRanges = $fwdHeaderAcceptRanges;
        $this->fwdHeaderCacheControl = $fwdHeaderCacheControl;
        $this->fwdHeaderContentDisposition = $fwdHeaderContentDisposition;
        $this->fwdHeaderContentEncoding = $fwdHeaderContentEncoding;
        $this->fwdHeaderContentLanguage = $fwdHeaderContentLanguage;
        $this->fwdHeaderContentRange = $fwdHeaderContentRange;
        $this->fwdHeaderContentType = $fwdHeaderContentType;
        $this->fwdHeaderEtag = $fwdHeaderEtag;
        $this->fwdHeaderExpires = $fwdHeaderExpires;
        $this->fwdHeaderLastModified = $fwdHeaderLastModified;
        $this->body = $body;
        parent::__construct($options);
    }
}