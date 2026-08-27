<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic;

use AlibabaCloud\Oss\V2\Client;
use AlibabaCloud\Oss\V2\Config;

/**
 * Factory for a {@see Client} that operates on the bucket spaces of an agentic bucket.
 *
 * Pass the short bucket name in each request; the returned client automatically
 * resolves it to the full name `{bucket}-{accountId}-{region}-bs-apsr`, where
 * `accountId` and `region` come from the {@see Config}. For example, with bucket
 * `my-space`, account `123456` and region `cn-hangzhou`, the resolved name is
 * `my-space-123456-cn-hangzhou-bs-apsr`. Therefore both `accountId` and `region`
 * must be configured.
 *
 * The returned client is a regular {@see Client}, so all standard object and
 * bucket operations (e.g. putObject, getObject, listObjects) are available.
 */
final class BucketSpaceClient
{
    /**
     * Creates a {@see Client} that resolves logical bucket names to bucket spaces.
     * @param Config $config
     * @param array $options
     * @return Client
     */
    public static function newClient(Config $config, array $options = []): Client
    {
        [$cfg, $options] = AgenticProvider::configureClientOptions($config, $options, 'bs-apsr');
        return new Client($cfg, $options);
    }
}
