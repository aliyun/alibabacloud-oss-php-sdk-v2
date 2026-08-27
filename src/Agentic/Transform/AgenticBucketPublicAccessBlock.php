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
 * Class AgenticBucketPublicAccessBlock
 * @package AlibabaCloud\Oss\V2\Agentic\Transform
 */
final class AgenticBucketPublicAccessBlock
{
    /**
     * @param Models\PutAgenticBucketPublicAccessBlockRequest $request
     * @return OperationInput
     */
    public static function fromPutAgenticBucketPublicAccessBlock(Models\PutAgenticBucketPublicAccessBlockRequest $request): OperationInput
    {
        $input = new OperationInput(
            'PutAgenticBucketPublicAccessBlock',
            'PUT',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('publicAccessBlock', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'publicAccessBlock']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\PutAgenticBucketPublicAccessBlockResult
     */
    public static function toPutAgenticBucketPublicAccessBlock(OperationOutput $output): Models\PutAgenticBucketPublicAccessBlockResult
    {
        $result = new Models\PutAgenticBucketPublicAccessBlockResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\GetAgenticBucketPublicAccessBlockRequest $request
     * @return OperationInput
     */
    public static function fromGetAgenticBucketPublicAccessBlock(Models\GetAgenticBucketPublicAccessBlockRequest $request): OperationInput
    {
        $input = new OperationInput(
            'GetAgenticBucketPublicAccessBlock',
            'GET',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('publicAccessBlock', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'publicAccessBlock']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\GetAgenticBucketPublicAccessBlockResult
     */
    public static function toGetAgenticBucketPublicAccessBlock(OperationOutput $output): Models\GetAgenticBucketPublicAccessBlockResult
    {
        $result = new Models\GetAgenticBucketPublicAccessBlockResult();
        $customDeserializer = [
            [Deserializer::class, 'deserializeOutputBody'],
        ];
        Deserializer::deserializeOutput($result, $output, $customDeserializer);
        return $result;
    }

    /**
     * @param Models\DeleteAgenticBucketPublicAccessBlockRequest $request
     * @return OperationInput
     */
    public static function fromDeleteAgenticBucketPublicAccessBlock(Models\DeleteAgenticBucketPublicAccessBlockRequest $request): OperationInput
    {
        $input = new OperationInput(
            'DeleteAgenticBucketPublicAccessBlock',
            'DELETE',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('publicAccessBlock', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'publicAccessBlock']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\DeleteAgenticBucketPublicAccessBlockResult
     */
    public static function toDeleteAgenticBucketPublicAccessBlock(OperationOutput $output): Models\DeleteAgenticBucketPublicAccessBlockResult
    {
        $result = new Models\DeleteAgenticBucketPublicAccessBlockResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }
}
