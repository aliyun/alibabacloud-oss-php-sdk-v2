<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Types;

use AlibabaCloud\Oss\V2\OperationInput;

/**
 * Builds the request URL (scheme, host and path, without the query string) for
 * an {@see OperationInput}, taking precedence over the default address-style
 * based host construction.
 */
interface EndpointProvider
{
    /**
     * @param OperationInput $input
     * @return string|null the request URL, or null to fall back to the default construction
     */
    public function buildUrl(OperationInput $input): ?string;
}
