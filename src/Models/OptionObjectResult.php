<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\ResultModel;
use AlibabaCloud\Oss\V2\Annotation\TagHeader;

/**
 * The result for the OptionObject operation.
 * Class OptionObjectResult
 * @package AlibabaCloud\Oss\V2\Models
 */
final class OptionObjectResult extends ResultModel
{
    /**
     * The origins allowed for cross-origin resource sharing (CORS).
     * @var string|null
     */
    #[TagHeader(rename: 'Access-Control-Allow-Origin', type: 'string')]
    public ?string $accessControlAllowOrigin;

    /**
     * The methods allowed for CORS.
     * @var string|null
     */
    #[TagHeader(rename: 'Access-Control-Allow-Methods', type: 'string')]
    public ?string $accessControlAllowMethods;

    /**
     * The headers allowed for CORS.
     * @var string|null
     */
    #[TagHeader(rename: 'Access-Control-Allow-Headers', type: 'string')]
    public ?string $accessControlAllowHeaders;
    /**
     * The headers that can be accessed by JavaScript applications on the client.
     * @var string|null
     */
    #[TagHeader(rename: 'Access-Control-Expose-Headers', type: 'string')]
    public ?string $accessControlExposeHeaders;

    /**
     * The maximum caching period for CORS.
     * @var int|null
     */
    #[TagHeader(rename: 'Access-Control-Max-Age', type: 'int')]
    public ?int $accessControlMaxAge;

    /**
     * OptionObjectRequest constructor.
     * @param string|null $accessControlAllowOrigin
     * @param string|null $accessControlAllowMethods
     * @param string|null $accessControlAllowHeaders
     * @param string|null $accessControlExposeHeaders
     * @param int|null $accessControlMaxAge
     */
    public function __construct(
        ?string $accessControlAllowOrigin = null,
        ?string $accessControlAllowMethods = null,
        ?string $accessControlAllowHeaders = null,
        ?string $accessControlExposeHeaders = null,
        ?int $accessControlMaxAge = null
    )
    {
        $this->accessControlAllowOrigin = $accessControlAllowOrigin;
        $this->accessControlAllowMethods = $accessControlAllowMethods;
        $this->accessControlAllowHeaders = $accessControlAllowHeaders;
        $this->accessControlExposeHeaders = $accessControlExposeHeaders;
        $this->accessControlMaxAge = $accessControlMaxAge;
    }
}
