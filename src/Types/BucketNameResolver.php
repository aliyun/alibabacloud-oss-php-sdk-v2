<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Types;

use AlibabaCloud\Oss\V2\OperationInput;

/**
 * Resolves the physical bucket name used for signing from the logical bucket
 * carried by an {@see OperationInput}. Invoked only when the input carries a bucket.
 */
interface BucketNameResolver
{
    /**
     * @param OperationInput $input
     * @return string|null the resolved physical bucket name
     */
    public function buildBucketName(OperationInput $input): ?string;
}
