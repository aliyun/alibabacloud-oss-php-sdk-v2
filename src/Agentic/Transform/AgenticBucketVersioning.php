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
 * Class AgenticBucketVersioning
 * @package AlibabaCloud\Oss\V2\Agentic\Transform
 */
final class AgenticBucketVersioning
{
    /**
     * @param Models\PutAgenticBucketVersioningRequest $request
     * @return OperationInput
     */
    public static function fromPutAgenticBucketVersioning(Models\PutAgenticBucketVersioningRequest $request): OperationInput
    {
        $input = new OperationInput(
            'PutAgenticBucketVersioning',
            'PUT',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('versioning', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'versioning']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\PutAgenticBucketVersioningResult
     */
    public static function toPutAgenticBucketVersioning(OperationOutput $output): Models\PutAgenticBucketVersioningResult
    {
        $result = new Models\PutAgenticBucketVersioningResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\GetAgenticBucketVersioningRequest $request
     * @return OperationInput
     */
    public static function fromGetAgenticBucketVersioning(Models\GetAgenticBucketVersioningRequest $request): OperationInput
    {
        $input = new OperationInput(
            'GetAgenticBucketVersioning',
            'GET',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('versioning', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'versioning']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\GetAgenticBucketVersioningResult
     */
    public static function toGetAgenticBucketVersioning(OperationOutput $output): Models\GetAgenticBucketVersioningResult
    {
        $result = new Models\GetAgenticBucketVersioningResult();
        $customDeserializer = [
            [Deserializer::class, 'deserializeOutputBody'],
        ];
        Deserializer::deserializeOutput($result, $output, $customDeserializer);
        return $result;
    }
}
