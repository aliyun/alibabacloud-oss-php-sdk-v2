<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic;

use AlibabaCloud\Oss\V2\Config;

/**
 * A helper that resolves a bucket space prefix to its physical bucket name.
 * The physical name is `{prefix}-{accountId}-{region}-bs-apsr`, so both `accountId`
 * and `region` must be provided (via {@see Config} or directly).
 *
 * Class BucketSpaceHelper
 * @package AlibabaCloud\Oss\V2\Agentic
 */
final class BucketSpaceHelper
{
    /**
     * @var string
     */
    private string $accountId;

    /**
     * @var string
     */
    private string $region;

    /**
     * BucketSpaceHelper constructor.
     * @param Config|string|null $configOrAccountId A Config instance, or the accountId string.
     * @param string|null $region The region, when the accountId string form is used.
     */
    public function __construct($configOrAccountId = null, ?string $region = null)
    {
        if ($configOrAccountId instanceof Config) {
            $this->accountId = $configOrAccountId->getAccountId() ?? '';
            $this->region = $configOrAccountId->getRegion() ?? '';
        } else {
            $this->accountId = $configOrAccountId ?? '';
            $this->region = $region ?? '';
        }
    }

    /**
     * Resolves a bucket space prefix to its physical bucket name
     * `{prefix}-{accountId}-{region}-bs-apsr`.
     * @param string $prefix
     * @return string
     */
    public function toBucketName(string $prefix): string
    {
        return sprintf('%s-%s-%s-bs-apsr', $prefix, $this->accountId, $this->region);
    }
}
