<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Agentic\Transform;

use AlibabaCloud\Oss\V2\OperationInput;
use AlibabaCloud\Oss\V2\OperationOutput;
use AlibabaCloud\Oss\V2\Agentic\Models;
use AlibabaCloud\Oss\V2\Deserializer;
use AlibabaCloud\Oss\V2\Serializer;
use AlibabaCloud\Oss\V2\Utils;
use AlibabaCloud\Oss\V2\Transform\Functions;

/**
 * Class AgenticBucketBasic
 * @package AlibabaCloud\Oss\V2\Agentic\Transform
 */
final class AgenticBucketBasic
{
    /**
     * @param Models\CreateAgenticBucketRequest $request
     * @return OperationInput
     */
    public static function fromCreateAgenticBucket(Models\CreateAgenticBucketRequest $request): OperationInput
    {
        $input = new OperationInput(
            'CreateAgenticBucket',
            'PUT',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\CreateAgenticBucketResult
     */
    public static function toCreateAgenticBucket(OperationOutput $output): Models\CreateAgenticBucketResult
    {
        $result = new Models\CreateAgenticBucketResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\DeleteAgenticBucketRequest $request
     * @return OperationInput
     */
    public static function fromDeleteAgenticBucket(Models\DeleteAgenticBucketRequest $request): OperationInput
    {
        $input = new OperationInput(
            'DeleteAgenticBucket',
            'DELETE',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\DeleteAgenticBucketResult
     */
    public static function toDeleteAgenticBucket(OperationOutput $output): Models\DeleteAgenticBucketResult
    {
        $result = new Models\DeleteAgenticBucketResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\GetAgenticBucketRequest $request
     * @return OperationInput
     */
    public static function fromGetAgenticBucket(Models\GetAgenticBucketRequest $request): OperationInput
    {
        $input = new OperationInput(
            'GetAgenticBucket',
            'GET',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\GetAgenticBucketResult
     */
    public static function toGetAgenticBucket(OperationOutput $output): Models\GetAgenticBucketResult
    {
        $result = new Models\GetAgenticBucketResult();
        $customDeserializer = [
            [Deserializer::class, 'deserializeOutputBody'],
        ];
        Deserializer::deserializeOutput($result, $output, $customDeserializer);
        return $result;
    }

    /**
     * @param Models\ListAgenticBucketsRequest $request
     * @return OperationInput
     */
    public static function fromListAgenticBuckets(Models\ListAgenticBucketsRequest $request): OperationInput
    {
        $input = new OperationInput(
            'ListAgenticBuckets',
            'GET',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setOpMetadata('sub-resource', ['agenticBucket']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\ListAgenticBucketsResult
     */
    public static function toListAgenticBuckets(OperationOutput $output): Models\ListAgenticBucketsResult
    {
        $result = new Models\ListAgenticBucketsResult();
        $customDeserializer = [
            static function (Models\ListAgenticBucketsResult $result, OperationOutput $output) {
                $body = $output->getBody() != null ? $output->getBody()->getContents() : '';
                Functions::assertXmlRoot($body, 'ListAgenticBucketsResult');
                $xml = Utils::parseXml($body);
                $result->region = Functions::tryToString($xml->Region);
                $result->owner = Functions::tryToString($xml->Owner);
                $result->continuationToken = Functions::tryToString($xml->ContinuationToken);
                $result->nextContinuationToken = Functions::tryToString($xml->NextContinuationToken);
                $result->isTruncated = Functions::tryToBool($xml->IsTruncated);
                if (isset($xml->AgenticBuckets->AgenticBucket)) {
                    $result->agenticBuckets = [];
                    foreach ($xml->AgenticBuckets->AgenticBucket as $item) {
                        $result->agenticBuckets[] = new Models\AgenticBucketSummary(
                            Functions::tryToString($item->Name),
                            Functions::tryToString($item->StorageClass),
                            Functions::tryToString($item->DataRedundancyType),
                            Functions::tryToString($item->CreateTime)
                        );
                    }
                }
            },
        ];
        Deserializer::deserializeOutput($result, $output, $customDeserializer);
        return $result;
    }

    /**
     * @param Models\PutAgenticBucketStatusRequest $request
     * @return OperationInput
     */
    public static function fromPutAgenticBucketStatus(Models\PutAgenticBucketStatusRequest $request): OperationInput
    {
        $input = new OperationInput(
            'PutAgenticBucketStatus',
            'PUT',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('status', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'status']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\PutAgenticBucketStatusResult
     */
    public static function toPutAgenticBucketStatus(OperationOutput $output): Models\PutAgenticBucketStatusResult
    {
        $result = new Models\PutAgenticBucketStatusResult();
        Deserializer::deserializeOutput($result, $output);
        return $result;
    }

    /**
     * @param Models\ListBucketSpacesRequest $request
     * @return OperationInput
     */
    public static function fromListBucketSpaces(Models\ListBucketSpacesRequest $request): OperationInput
    {
        $input = new OperationInput(
            'ListBucketSpaces',
            'GET',
            ['Content-Type' => 'application/xml']
        );
        $input->setParameter('agenticBucket', '');
        $input->setParameter('bucketSpace', '');
        $input->setBucket($request->bucket ?? '');
        $input->setOpMetadata('sub-resource', ['agenticBucket', 'bucketSpace']);

        $customSerializer = [
            [Functions::class, 'addContentMd5']
        ];
        Serializer::serializeInput($request, $input, $customSerializer);
        return $input;
    }

    /**
     * @param OperationOutput $output
     * @return Models\ListBucketSpacesResult
     */
    public static function toListBucketSpaces(OperationOutput $output): Models\ListBucketSpacesResult
    {
        $result = new Models\ListBucketSpacesResult();
        $customDeserializer = [
            static function (Models\ListBucketSpacesResult $result, OperationOutput $output) {
                $body = $output->getBody() != null ? $output->getBody()->getContents() : '';
                Functions::assertXmlRoot($body, 'ListBucketSpacesResult');
                $xml = Utils::parseXml($body);
                if (isset($xml->Owner)) {
                    $result->owner = new \AlibabaCloud\Oss\V2\Models\Owner(
                        Functions::tryToString($xml->Owner->ID),
                        Functions::tryToString($xml->Owner->DisplayName)
                    );
                }
                $result->prefix = Functions::tryToString($xml->Prefix);
                $result->maxKeys = Functions::tryToInt($xml->MaxKeys);
                $result->continuationToken = Functions::tryToString($xml->ContinuationToken);
                $result->nextContinuationToken = Functions::tryToString($xml->NextContinuationToken);
                $result->startAfter = Functions::tryToString($xml->StartAfter);
                $result->isTruncated = Functions::tryToBool($xml->IsTruncated);
                if (isset($xml->BucketSpaces->BucketSpace)) {
                    $result->bucketSpaces = [];
                    foreach ($xml->BucketSpaces->BucketSpace as $item) {
                        $result->bucketSpaces[] = new Models\BucketSpaceSummary(
                            Functions::tryToString($item->Name),
                            Functions::tryToString($item->Location),
                            Functions::tryToString($item->CreationDate),
                            Functions::tryToString($item->StorageClass)
                        );
                    }
                }
            },
        ];
        Deserializer::deserializeOutput($result, $output, $customDeserializer);
        return $result;
    }
}
