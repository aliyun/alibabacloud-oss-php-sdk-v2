<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Transform;

use AlibabaCloud\Oss\V2\OperationInput;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Agentic\Models;
use AlibabaCloud\Oss\V2\Deserializer;
use AlibabaCloud\Oss\V2\Serializer;
use AlibabaCloud\Oss\V2\Transform\Functions;

/**
 * Class AgenticBucketPolicy
 * @package AlibabaCloud\Oss\V2\Agentic\Transform
 */
final class AgenticBucketPolicy
{
    /**
     * @param Models\PutAgenticBucketPolicyRequest $request
     * @return OperationInput
     */
    public static function fromPutAgenticBucketPolicy(Models\PutAgenticBucketPolicyRequest $request): OperationInput
    {
        $input = new OperationInput(
            'PutAgenticBucketPolicy',
            'PUT',
            ['Content-Type' => 'application/json']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('policy', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'policy']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\PutAgenticBucketPolicyResult
     */
    public static function toPutAgenticBucketPolicy(OperationOutput $output): Models\PutAgenticBucketPolicyResult
    {
        $result = new Models\PutAgenticBucketPolicyResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\GetAgenticBucketPolicyRequest $request
     * @return OperationInput
     */
    public static function fromGetAgenticBucketPolicy(Models\GetAgenticBucketPolicyRequest $request): OperationInput
    {
        $input = new OperationInput(
            'GetAgenticBucketPolicy',
            'GET',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('policy', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'policy']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\GetAgenticBucketPolicyResult
     */
    public static function toGetAgenticBucketPolicy(OperationOutput $output): Models\GetAgenticBucketPolicyResult
    {
        $result = new Models\GetAgenticBucketPolicyResult();
        $customDeserializer = [
            static function (Models\GetAgenticBucketPolicyResult $result, OperationOutput $output) {
                $result->policy = $output->getBody() != null ? $output->getBody()->getContents() : null;
            },
        ];
        Deserializer::deserializeOutput($result, $output, $customDeserializer);
        return $result;
    }

    /**
     * @param Models\DeleteAgenticBucketPolicyRequest $request
     * @return OperationInput
     */
    public static function fromDeleteAgenticBucketPolicy(Models\DeleteAgenticBucketPolicyRequest $request): OperationInput
    {
        $input = new OperationInput(
            'DeleteAgenticBucketPolicy',
            'DELETE',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('policy', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'policy']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\DeleteAgenticBucketPolicyResult
     */
    public static function toDeleteAgenticBucketPolicy(OperationOutput $output): Models\DeleteAgenticBucketPolicyResult
    {
        $result = new Models\DeleteAgenticBucketPolicyResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }
}
