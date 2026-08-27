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
 * Class AgenticBucketEncryption
 * @package AlibabaCloud\Oss\V2\Agentic\Transform
 */
final class AgenticBucketEncryption
{
    /**
     * @param Models\PutAgenticBucketEncryptionRequest $request
     * @return OperationInput
     */
    public static function fromPutAgenticBucketEncryption(Models\PutAgenticBucketEncryptionRequest $request): OperationInput
    {
        $input = new OperationInput(
            'PutAgenticBucketEncryption',
            'PUT',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('encryption', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'encryption']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\PutAgenticBucketEncryptionResult
     */
    public static function toPutAgenticBucketEncryption(OperationOutput $output): Models\PutAgenticBucketEncryptionResult
    {
        $result = new Models\PutAgenticBucketEncryptionResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\GetAgenticBucketEncryptionRequest $request
     * @return OperationInput
     */
    public static function fromGetAgenticBucketEncryption(Models\GetAgenticBucketEncryptionRequest $request): OperationInput
    {
        $input = new OperationInput(
            'GetAgenticBucketEncryption',
            'GET',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('encryption', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'encryption']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\GetAgenticBucketEncryptionResult
     */
    public static function toGetAgenticBucketEncryption(OperationOutput $output): Models\GetAgenticBucketEncryptionResult
    {
        $result = new Models\GetAgenticBucketEncryptionResult();
        $customDeserializer = [
            [Deserializer::class, 'deserializeOutputBody'],
        ];
        Deserializer::deserializeOutput($result, $output, $customDeserializer);
        return $result;
    }

    /**
     * @param Models\DeleteAgenticBucketEncryptionRequest $request
     * @return OperationInput
     */
    public static function fromDeleteAgenticBucketEncryption(Models\DeleteAgenticBucketEncryptionRequest $request): OperationInput
    {
        $input = new OperationInput(
            'DeleteAgenticBucketEncryption',
            'DELETE',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('encryption', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'encryption']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\DeleteAgenticBucketEncryptionResult
     */
    public static function toDeleteAgenticBucketEncryption(OperationOutput $output): Models\DeleteAgenticBucketEncryptionResult
    {
        $result = new Models\DeleteAgenticBucketEncryptionResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }
}
