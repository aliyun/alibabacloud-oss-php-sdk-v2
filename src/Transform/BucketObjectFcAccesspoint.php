<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Transform;

use AlibabaCloud\Oss\V2\OperationInput;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Models;
use AlibabaCloud\Oss\V2\Deserializer;
use AlibabaCloud\Oss\V2\Serializer;

/**
 * Class BucketObjectFcAccessPoint
 * @package AlibabaCloud\Oss\V2\Transform
 */
final class BucketObjectFcAccessPoint
{
    /**
     * @param Models\CreateAccessPointForObjectProcessRequest $request
     * @return OperationInput
     */
    public static function fromCreateAccessPointForObjectProcess(Models\CreateAccessPointForObjectProcessRequest $request): OperationInput
    {
        $input = new OperationInput(
            'CreateAccessPointForObjectProcess',
            'PUT',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('accessPointForObjectProcess', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['accessPointForObjectProcess',]);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\CreateAccessPointForObjectProcessResult
     */
    public static function toCreateAccessPointForObjectProcess(OperationOutput $output): Models\CreateAccessPointForObjectProcessResult
    {
        $result = new Models\CreateAccessPointForObjectProcessResult();
        $customDeserializer = [
            [Deserializer::class, 'deserializeOutputInnerBody'],
        ];
        Deserializer::deserializeOutput($result, $output, $customDeserializer);
        return $result;
    }

    /**
     * @param Models\GetAccessPointForObjectProcessRequest $request
     * @return OperationInput
     */
    public static function fromGetAccessPointForObjectProcess(Models\GetAccessPointForObjectProcessRequest $request): OperationInput
    {
        $input = new OperationInput(
            'GetAccessPointForObjectProcess',
            'GET',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('accessPointForObjectProcess', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['accessPointForObjectProcess',]);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\GetAccessPointForObjectProcessResult
     */
    public static function toGetAccessPointForObjectProcess(OperationOutput $output): Models\GetAccessPointForObjectProcessResult
    {
        $result = new Models\GetAccessPointForObjectProcessResult();
        $customDeserializer = [
            [Deserializer::class, 'deserializeOutputInnerBody'],
        ];
        Deserializer::deserializeOutput($result, $output, $customDeserializer);
        return $result;
    }

    /**
     * @param Models\ListAccessPointsForObjectProcessRequest $request
     * @return OperationInput
     */
    public static function fromListAccessPointsForObjectProcess(Models\ListAccessPointsForObjectProcessRequest $request): OperationInput
    {
        $input = new OperationInput(
            'ListAccessPointsForObjectProcess',
            'GET',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('accessPointForObjectProcess', '');
        $input->setOpMetadata('sub-resource', ['accessPointForObjectProcess',]);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\ListAccessPointsForObjectProcessResult
     */
    public static function toListAccessPointsForObjectProcess(OperationOutput $output): Models\ListAccessPointsForObjectProcessResult
    {
        $result = new Models\ListAccessPointsForObjectProcessResult();
        $customDeserializer = [
            [Deserializer::class, 'deserializeOutputInnerBody'],
        ];
        Deserializer::deserializeOutput($result, $output, $customDeserializer);
        return $result;
    }

    /**
     * @param Models\DeleteAccessPointForObjectProcessRequest $request
     * @return OperationInput
     */
    public static function fromDeleteAccessPointForObjectProcess(Models\DeleteAccessPointForObjectProcessRequest $request): OperationInput
    {
        $input = new OperationInput(
            'DeleteAccessPointForObjectProcess',
            'DELETE',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('accessPointForObjectProcess', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['accessPointForObjectProcess',]);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\DeleteAccessPointForObjectProcessResult
     */
    public static function toDeleteAccessPointForObjectProcess(OperationOutput $output): Models\DeleteAccessPointForObjectProcessResult
    {
        $result = new Models\DeleteAccessPointForObjectProcessResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\GetAccessPointConfigForObjectProcessRequest $request
     * @return OperationInput
     */
    public static function fromGetAccessPointConfigForObjectProcess(Models\GetAccessPointConfigForObjectProcessRequest $request): OperationInput
    {
        $input = new OperationInput(
            'GetAccessPointConfigForObjectProcess',
            'GET',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('accessPointConfigForObjectProcess', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['accessPointConfigForObjectProcess',]);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\GetAccessPointConfigForObjectProcessResult
     */
    public static function toGetAccessPointConfigForObjectProcess(OperationOutput $output): Models\GetAccessPointConfigForObjectProcessResult
    {
        $result = new Models\GetAccessPointConfigForObjectProcessResult();
        $customDeserializer = [
            [Deserializer::class, 'deserializeOutputInnerBody'],
        ];
        Deserializer::deserializeOutput($result, $output, $customDeserializer);
        return $result;
    }

    /**
     * @param Models\PutAccessPointConfigForObjectProcessRequest $request
     * @return OperationInput
     */
    public static function fromPutAccessPointConfigForObjectProcess(Models\PutAccessPointConfigForObjectProcessRequest $request): OperationInput
    {
        $input = new OperationInput(
            'PutAccessPointConfigForObjectProcess',
            'PUT',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('accessPointConfigForObjectProcess', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['accessPointConfigForObjectProcess',]);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\PutAccessPointConfigForObjectProcessResult
     */
    public static function toPutAccessPointConfigForObjectProcess(OperationOutput $output): Models\PutAccessPointConfigForObjectProcessResult
    {
        $result = new Models\PutAccessPointConfigForObjectProcessResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\PutAccessPointPolicyForObjectProcessRequest $request
     * @return OperationInput
     */
    public static function fromPutAccessPointPolicyForObjectProcess(Models\PutAccessPointPolicyForObjectProcessRequest $request): OperationInput
    {
        $input = new OperationInput(
            'PutAccessPointPolicyForObjectProcess',
            'PUT',
        );
        $input->setParameter('accessPointPolicyForObjectProcess', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['accessPointPolicyForObjectProcess',]);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\PutAccessPointPolicyForObjectProcessResult
     */
    public static function toPutAccessPointPolicyForObjectProcess(OperationOutput $output): Models\PutAccessPointPolicyForObjectProcessResult
    {
        $result = new Models\PutAccessPointPolicyForObjectProcessResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\GetAccessPointPolicyForObjectProcessRequest $request
     * @return OperationInput
     */
    public static function fromGetAccessPointPolicyForObjectProcess(Models\GetAccessPointPolicyForObjectProcessRequest $request): OperationInput
    {
        $input = new OperationInput(
            'GetAccessPointPolicyForObjectProcess',
            'GET',
        );
        $input->setParameter('accessPointPolicyForObjectProcess', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['accessPointPolicyForObjectProcess',]);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\GetAccessPointPolicyForObjectProcessResult
     */
    public static function toGetAccessPointPolicyForObjectProcess(OperationOutput $output): Models\GetAccessPointPolicyForObjectProcessResult
    {
        $result = new Models\GetAccessPointPolicyForObjectProcessResult();
        if ($output->getBody() !== null) {
            $result->body = $output->getBody()->getContents();
        }
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\DeleteAccessPointPolicyForObjectProcessRequest $request
     * @return OperationInput
     */
    public static function fromDeleteAccessPointPolicyForObjectProcess(Models\DeleteAccessPointPolicyForObjectProcessRequest $request): OperationInput
    {
        $input = new OperationInput(
            'DeleteAccessPointPolicyForObjectProcess',
            'DELETE',
        );
        $input->setParameter('accessPointPolicyForObjectProcess', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['accessPointPolicyForObjectProcess',]);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\DeleteAccessPointPolicyForObjectProcessResult
     */
    public static function toDeleteAccessPointPolicyForObjectProcess(OperationOutput $output): Models\DeleteAccessPointPolicyForObjectProcessResult
    {
        $result = new Models\DeleteAccessPointPolicyForObjectProcessResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\WriteGetObjectResponseRequest $request
     * @return OperationInput
     */
    public static function fromWriteGetObjectResponse(Models\WriteGetObjectResponseRequest $request): OperationInput
    {
        $input = new OperationInput(
            'WriteGetObjectResponse',
            'POST',
        );
        $input->setParameter('x-oss-write-get-object-response', '');
        $input->setOpMetadata('sub-resource', ['x-oss-write-get-object-response',]);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\WriteGetObjectResponseResult
     */
    public static function toDeleteWriteGetObjectResponse(OperationOutput $output): Models\WriteGetObjectResponseResult
    {
        $result = new Models\WriteGetObjectResponseResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }
}
