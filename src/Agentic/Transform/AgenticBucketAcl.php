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
 * Class AgenticBucketAcl
 * @package AlibabaCloud\Oss\V2\Agentic\Transform
 */
final class AgenticBucketAcl
{
    /**
     * @param Models\PutAgenticBucketAclRequest $request
     * @return OperationInput
     */
    public static function fromPutAgenticBucketAcl(Models\PutAgenticBucketAclRequest $request): OperationInput
    {
        $input = new OperationInput(
            'PutAgenticBucketAcl',
            'PUT',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('acl', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'acl']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\PutAgenticBucketAclResult
     */
    public static function toPutAgenticBucketAcl(OperationOutput $output): Models\PutAgenticBucketAclResult
    {
        $result = new Models\PutAgenticBucketAclResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\GetAgenticBucketAclRequest $request
     * @return OperationInput
     */
    public static function fromGetAgenticBucketAcl(Models\GetAgenticBucketAclRequest $request): OperationInput
    {
        $input = new OperationInput(
            'GetAgenticBucketAcl',
            'GET',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('acl', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'acl']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\GetAgenticBucketAclResult
     */
    public static function toGetAgenticBucketAcl(OperationOutput $output): Models\GetAgenticBucketAclResult
    {
        $result = new Models\GetAgenticBucketAclResult();
        $customDeserializer = [
            [Deserializer::class, 'deserializeOutputBody'],
        ];
        Deserializer::deserializeOutput($result, $output, $customDeserializer);
        return $result;
    }
}
