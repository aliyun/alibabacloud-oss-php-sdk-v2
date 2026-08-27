<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic;

use GuzzleHttp;
use AlibabaCloud\Oss\V2\Client;
use AlibabaCloud\Oss\V2\Config;
use AlibabaCloud\Oss\V2\OperationInput;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Types;
use AlibabaCloud\Oss\V2\Agentic\Models;

/**
 * Client used to interact with the **Agentic Bucket** capability of
 * Alibaba Cloud Object Storage Service (OSS).
 *
 * The bucket name that you pass to a request is a logical prefix. Internally it is
 * resolved to `{prefix}-{accountId}-{region}-ab-apsr`, so both `accountId` and `region`
 * must be configured on the {@see Config}.
 *
 * @method Models\CreateAgenticBucketResult createAgenticBucket(Models\CreateAgenticBucketRequest $request, array $args = []) Creates an agentic bucket.
 * @method GuzzleHttp\Promise\Promise createAgenticBucketAsync(Models\CreateAgenticBucketRequest $request, array $args = []) Creates an agentic bucket.
 * @method Models\DeleteAgenticBucketResult deleteAgenticBucket(Models\DeleteAgenticBucketRequest $request, array $args = []) Deletes an agentic bucket.
 * @method GuzzleHttp\Promise\Promise deleteAgenticBucketAsync(Models\DeleteAgenticBucketRequest $request, array $args = []) Deletes an agentic bucket.
 * @method Models\GetAgenticBucketResult getAgenticBucket(Models\GetAgenticBucketRequest $request, array $args = []) Queries the information about an agentic bucket.
 * @method GuzzleHttp\Promise\Promise getAgenticBucketAsync(Models\GetAgenticBucketRequest $request, array $args = []) Queries the information about an agentic bucket.
 * @method Models\ListAgenticBucketsResult listAgenticBuckets(Models\ListAgenticBucketsRequest $request, array $args = []) Lists agentic buckets that belong to the current account.
 * @method GuzzleHttp\Promise\Promise listAgenticBucketsAsync(Models\ListAgenticBucketsRequest $request, array $args = []) Lists agentic buckets that belong to the current account.
 * @method Models\PutAgenticBucketStatusResult putAgenticBucketStatus(Models\PutAgenticBucketStatusRequest $request, array $args = []) Modifies the status of an agentic bucket.
 * @method GuzzleHttp\Promise\Promise putAgenticBucketStatusAsync(Models\PutAgenticBucketStatusRequest $request, array $args = []) Modifies the status of an agentic bucket.
 * @method Models\ListBucketSpacesResult listBucketSpaces(Models\ListBucketSpacesRequest $request, array $args = []) Lists the bucket spaces of an agentic bucket.
 * @method GuzzleHttp\Promise\Promise listBucketSpacesAsync(Models\ListBucketSpacesRequest $request, array $args = []) Lists the bucket spaces of an agentic bucket.
 * @method Models\PutAgenticBucketAclResult putAgenticBucketAcl(Models\PutAgenticBucketAclRequest $request, array $args = []) Configures the ACL of an agentic bucket.
 * @method GuzzleHttp\Promise\Promise putAgenticBucketAclAsync(Models\PutAgenticBucketAclRequest $request, array $args = []) Configures the ACL of an agentic bucket.
 * @method Models\GetAgenticBucketAclResult getAgenticBucketAcl(Models\GetAgenticBucketAclRequest $request, array $args = []) Queries the ACL of an agentic bucket.
 * @method GuzzleHttp\Promise\Promise getAgenticBucketAclAsync(Models\GetAgenticBucketAclRequest $request, array $args = []) Queries the ACL of an agentic bucket.
 * @method Models\PutAgenticBucketEncryptionResult putAgenticBucketEncryption(Models\PutAgenticBucketEncryptionRequest $request, array $args = []) Configures encryption rules for an agentic bucket.
 * @method GuzzleHttp\Promise\Promise putAgenticBucketEncryptionAsync(Models\PutAgenticBucketEncryptionRequest $request, array $args = []) Configures encryption rules for an agentic bucket.
 * @method Models\GetAgenticBucketEncryptionResult getAgenticBucketEncryption(Models\GetAgenticBucketEncryptionRequest $request, array $args = []) Queries the encryption rules of an agentic bucket.
 * @method GuzzleHttp\Promise\Promise getAgenticBucketEncryptionAsync(Models\GetAgenticBucketEncryptionRequest $request, array $args = []) Queries the encryption rules of an agentic bucket.
 * @method Models\DeleteAgenticBucketEncryptionResult deleteAgenticBucketEncryption(Models\DeleteAgenticBucketEncryptionRequest $request, array $args = []) Deletes the encryption rules of an agentic bucket.
 * @method GuzzleHttp\Promise\Promise deleteAgenticBucketEncryptionAsync(Models\DeleteAgenticBucketEncryptionRequest $request, array $args = []) Deletes the encryption rules of an agentic bucket.
 * @method Models\PutAgenticBucketVersioningResult putAgenticBucketVersioning(Models\PutAgenticBucketVersioningRequest $request, array $args = []) Configures the versioning state for an agentic bucket.
 * @method GuzzleHttp\Promise\Promise putAgenticBucketVersioningAsync(Models\PutAgenticBucketVersioningRequest $request, array $args = []) Configures the versioning state for an agentic bucket.
 * @method Models\GetAgenticBucketVersioningResult getAgenticBucketVersioning(Models\GetAgenticBucketVersioningRequest $request, array $args = []) Queries the versioning state of an agentic bucket.
 * @method GuzzleHttp\Promise\Promise getAgenticBucketVersioningAsync(Models\GetAgenticBucketVersioningRequest $request, array $args = []) Queries the versioning state of an agentic bucket.
 * @method Models\PutAgenticBucketPolicyResult putAgenticBucketPolicy(Models\PutAgenticBucketPolicyRequest $request, array $args = []) Configures a policy for an agentic bucket.
 * @method GuzzleHttp\Promise\Promise putAgenticBucketPolicyAsync(Models\PutAgenticBucketPolicyRequest $request, array $args = []) Configures a policy for an agentic bucket.
 * @method Models\GetAgenticBucketPolicyResult getAgenticBucketPolicy(Models\GetAgenticBucketPolicyRequest $request, array $args = []) Queries the policy of an agentic bucket.
 * @method GuzzleHttp\Promise\Promise getAgenticBucketPolicyAsync(Models\GetAgenticBucketPolicyRequest $request, array $args = []) Queries the policy of an agentic bucket.
 * @method Models\DeleteAgenticBucketPolicyResult deleteAgenticBucketPolicy(Models\DeleteAgenticBucketPolicyRequest $request, array $args = []) Deletes the policy of an agentic bucket.
 * @method GuzzleHttp\Promise\Promise deleteAgenticBucketPolicyAsync(Models\DeleteAgenticBucketPolicyRequest $request, array $args = []) Deletes the policy of an agentic bucket.
 * @method Models\PutAgenticBucketPublicAccessBlockResult putAgenticBucketPublicAccessBlock(Models\PutAgenticBucketPublicAccessBlockRequest $request, array $args = []) Enables or disables Block Public Access for an agentic bucket.
 * @method GuzzleHttp\Promise\Promise putAgenticBucketPublicAccessBlockAsync(Models\PutAgenticBucketPublicAccessBlockRequest $request, array $args = []) Enables or disables Block Public Access for an agentic bucket.
 * @method Models\GetAgenticBucketPublicAccessBlockResult getAgenticBucketPublicAccessBlock(Models\GetAgenticBucketPublicAccessBlockRequest $request, array $args = []) Queries the Block Public Access configurations of an agentic bucket.
 * @method GuzzleHttp\Promise\Promise getAgenticBucketPublicAccessBlockAsync(Models\GetAgenticBucketPublicAccessBlockRequest $request, array $args = []) Queries the Block Public Access configurations of an agentic bucket.
 * @method Models\DeleteAgenticBucketPublicAccessBlockResult deleteAgenticBucketPublicAccessBlock(Models\DeleteAgenticBucketPublicAccessBlockRequest $request, array $args = []) Deletes the Block Public Access configurations of an agentic bucket.
 * @method GuzzleHttp\Promise\Promise deleteAgenticBucketPublicAccessBlockAsync(Models\DeleteAgenticBucketPublicAccessBlockRequest $request, array $args = []) Deletes the Block Public Access configurations of an agentic bucket.
 */
final class AgenticBucketClient
{
    private const API_MAPS = [
        'CreateAgenticBucket' => 'AgenticBucketBasic',
        'DeleteAgenticBucket' => 'AgenticBucketBasic',
        'GetAgenticBucket' => 'AgenticBucketBasic',
        'ListAgenticBuckets' => 'AgenticBucketBasic',
        'PutAgenticBucketStatus' => 'AgenticBucketBasic',
        'ListBucketSpaces' => 'AgenticBucketBasic',
        'PutAgenticBucketAcl' => 'AgenticBucketAcl',
        'GetAgenticBucketAcl' => 'AgenticBucketAcl',
        'PutAgenticBucketEncryption' => 'AgenticBucketEncryption',
        'GetAgenticBucketEncryption' => 'AgenticBucketEncryption',
        'DeleteAgenticBucketEncryption' => 'AgenticBucketEncryption',
        'PutAgenticBucketVersioning' => 'AgenticBucketVersioning',
        'GetAgenticBucketVersioning' => 'AgenticBucketVersioning',
        'PutAgenticBucketPolicy' => 'AgenticBucketPolicy',
        'GetAgenticBucketPolicy' => 'AgenticBucketPolicy',
        'DeleteAgenticBucketPolicy' => 'AgenticBucketPolicy',
        'PutAgenticBucketPublicAccessBlock' => 'AgenticBucketPublicAccessBlock',
        'GetAgenticBucketPublicAccessBlock' => 'AgenticBucketPublicAccessBlock',
        'DeleteAgenticBucketPublicAccessBlock' => 'AgenticBucketPublicAccessBlock',
    ];

    /**
     * @var Client
     */
    private Client $client;

    /**
     * AgenticBucketClient constructor.
     * @param Config $config
     * @param array $options
     */
    public function __construct(Config $config, array $options = [])
    {
        [$cfg, $options] = AgenticProvider::configureClientOptions($config, $options, 'ab-apsr');
        $this->client = new Client($cfg, $options);
    }

    /**
     * @param OperationInput $input
     * @param array $options
     * @return OperationOutput
     */
    public function invokeOperation(OperationInput $input, array $options = []): OperationOutput
    {
        return $this->client->invokeOperation($input, $options);
    }

    /**
     * @param OperationInput $input
     * @param array $options
     * @return GuzzleHttp\Promise\Promise
     */
    public function invokeOperationAsync(OperationInput $input, array $options = []): GuzzleHttp\Promise\Promise
    {
        return $this->client->invokeOperationAsync($input, $options);
    }

    /**
     * @param string $name The api name.
     * @param array $args
     * @return GuzzleHttp\Promise\PromiseInterface|mixed
     */
    public function __call($name, $args)
    {
        if (substr($name, -5) === 'Async') {
            $name = substr($name, 0, -5);
            $isAsync = true;
        }

        // api name
        $opName = ucfirst($name);
        $group = self::API_MAPS[$opName] ?? '';
        if ($group === '') {
            throw new \BadMethodCallException('Not implement ' . self::class . '::' . $name);
        }
        $class = __NAMESPACE__ . '\\Transform\\' . $group;
        $fromFunc = "from$opName";
        $toFunc = "to$opName";

        if (
            !\method_exists($class, $fromFunc) ||
            !\method_exists($class, $toFunc)
        ) {
            throw new \BadMethodCallException('Not implement ' . self::class . '::' . $name);
        }

        // args, {Operation}Request request, array options
        $request = isset($args[0]) ? $args[0] : [];
        $options = count($args) > 1 ? $args[1] : [];

        if (!($request instanceof Types\RequestModel)) {
            throw new \InvalidArgumentException('args[0] is not subclass of RequestModel, got ' . \gettype($request));
        }

        if (!\is_array($options)) {
            $options = [];
        }

        // execute
        $input = call_user_func([$class, $fromFunc], $request);
        $promise = $this->client->invokeOperationAsync($input, $options)->then(
            function (OperationOutput $output) use ($toFunc, $class) {
                return call_user_func([$class, $toFunc], $output);
            }
        );

        // result
        return !empty($isAsync) ? $promise : $promise->wait();
    }
}
