<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Transform;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\OperationInput;
use AlibabaCloud\Oss\V2\Utils;
use AlibabaCloud\Oss\V2\Exception;

final class Functions
{
    const API_MAPS_DEFAULT = [
        //bucket basic
        'PutBucket' => 'BucketBasic',
        'DeleteBucket' => 'BucketBasic',
        'PutBucketAcl' => 'BucketBasic',
        'GetBucketAcl' => 'BucketBasic',
        'GetBucketStat' => 'BucketBasic',
        'GetBucketLocation' => 'BucketBasic',
        'GetBucketInfo' => 'BucketBasic',
        'PutBucketVersioning' => 'BucketBasic',
        'GetBucketVersioning' => 'BucketBasic',
        'ListObjects' => 'BucketBasic',
        'ListObjectsV2' => 'BucketBasic',
        'ListObjectVersions' => 'BucketBasic',
        // service
        'ListBuckets' => 'BucketBasic',
        // region
        'DescribeRegions' => 'BucketBasic',
        //object basic
        'PutObject' => 'ObjectBasic',
        'CopyObject' => 'ObjectBasic',
        'GetObject' => 'ObjectBasic',
        'AppendObject' => 'ObjectBasic',
        'DeleteObject' => 'ObjectBasic',
        'DeleteMultipleObjects' => 'ObjectBasic',
        'HeadObject' => 'ObjectBasic',
        'GetObjectMeta' => 'ObjectBasic',
        'RestoreObject' => 'ObjectBasic',
        'CleanRestoredObject' => 'ObjectBasic',
        //object acl
        'PutObjectAcl' => 'ObjectBasic',
        'GetObjectAcl' => 'ObjectBasic',
        //object tagging
        'PutObjectTagging' => 'ObjectBasic',
        'GetObjectTagging' => 'ObjectBasic',
        'DeleteObjectTagging' => 'ObjectBasic',
        //object symlink
        'PutSymlink' => 'ObjectBasic',
        'GetSymlink' => 'ObjectBasic',
        //object process
        'ProcessObject' => 'ObjectBasic',
        'AsyncProcessObject' => 'ObjectBasic',
        //object multipart
        'InitiateMultipartUpload' => 'ObjectMultipart',
        'UploadPart' => 'ObjectMultipart',
        'CompleteMultipartUpload' => 'ObjectMultipart',
        'UploadPartCopy' => 'ObjectMultipart',
        'AbortMultipartUpload' => 'ObjectMultipart',
        'ListMultipartUploads' => 'ObjectMultipart',
        'ListParts' => 'ObjectMultipart',
    ];

    const API_MAPS_8_ONLY = [
        // bucket worm
        'InitiateBucketWorm' => 'BucketWorm',
        'AbortBucketWorm' => 'BucketWorm',
        'CompleteBucketWorm' => 'BucketWorm',
        'ExtendBucketWorm' => 'BucketWorm',
        'GetBucketWorm' => 'BucketWorm',
    ];

    public static function getTransformClass(string $apiName)
    {
        $group = self::API_MAPS_DEFAULT[$apiName] ?? '';
        if ($group == '') {
            $group = self::API_MAPS_8_ONLY[$apiName] ?? '';
            if ($group != '' && version_compare(PHP_VERSION, '8.0.0', '<')) {
                throw new \BadMethodCallException("$apiName is available only on php 8 or higher");
            }
        }
        if ($group != '') {
            $group = str_replace('Functions', $group, self::class);
        }
        return $group;
    }

    public static function serializeInputLite(RequestModel $request, OperationInput $input, array $customSerializer = []): OperationInput
    {
        $ro = new \ReflectionObject($request);

        //headers
        $hp = $ro->getProperty('headers');
        $hp->setAccessible(true);
        $h = $hp->getValue($request);
        if (is_array($h)) {
            foreach ($h as $key => $value) {
                $input->setHeader($key, (string)$value);
            }
        }

        //parameters
        $pp = $ro->getProperty('parameters');
        $pp->setAccessible(true);
        $p = $pp->getValue($request);
        if (is_array($p)) {
            foreach ($p as $key => $value) {
                $input->setParameter($key, (string)$value);
            }
        }

        //payload
        $pd = $ro->getProperty('payload');
        $pd->setAccessible(true);
        $payload = $pd->getValue($request);
        if ($payload instanceof \Psr\Http\Message\StreamInterface) {
            $input->setBody($payload);
        }

        // custom serializer
        foreach ($customSerializer as $serializer) {
            if (\is_callable($serializer)) {
                $serializer($request, $input);
            } else {
                call_user_func($serializer, $request, $input);
            }
        }

        return $input;
    }

    public static function assertFieldRequired(string $filed, $value)
    {
        if (!isset($value)) {
            throw new \InvalidArgumentException("missing required field, $filed.");
        }
    }

    public static function assertXmlRoot(string $xml, string $expect)
    {
        if (!preg_match("/<$expect([^>]*)>/", $xml)) {
            throw new Exception\DeserializationExecption("Not found tag <$expect>");
        }
    }

    public static function assertXmlNodeExist(\SimpleXMLElement $elem, $name)
    {
        if (empty($elem)) {
            throw new Exception\DeserializationExecption("Not found tag <$name>");
        }
    }

    public static function tryToString(\SimpleXMLElement &$elem)
    {
        if ($elem === null || ($elem->count() === 0 && trim((string)$elem) === '')) {
            return null;
        }
        return $elem->__toString();
    }

    public static function tryToDatetime(\SimpleXMLElement &$elem, ?string $format = null)
    {
        if ($elem === null || ($elem->count() === 0 && trim((string)$elem) === '')) {
            return null;
        }

        if ($format == null) {
            $format = 'Y-m-d\TH:i:s\Z';
        }
        $ret = \DateTime::createFromFormat(
            $format,
            $elem->__toString(),
            new \DateTimeZone('UTC')
        );

        if ($ret === false) {
            return null;
        }

        return $ret;
    }

    public static function tryToBool(\SimpleXMLElement &$elem)
    {
        if ($elem === null || ($elem->count() === 0 && trim((string)$elem) === '')) {
            return null;
        }
        return Utils::safetyBool(strtolower($elem->__toString()));
    }

    public static function tryToInt(\SimpleXMLElement &$elem)
    {
        if ($elem === null || ($elem->count() === 0 && trim((string)$elem) === '')) {
            return null;
        }
        return intval($elem->__toString());
    }

    public static function tryUrldecodeString(\SimpleXMLElement &$elem, bool $decode = false)
    {
        if ($elem === null || ($elem->count() === 0 && trim((string)$elem) === '')) {
            return null;
        }
        $val = $elem->__toString();
        return $decode == true ? \rawurldecode($val) : $val;
    }

    public static function tryUserMetadata(?array $headers)
    {
        if (!isset($headers)) {
            return null;
        }
        $result = [];
        foreach ($headers as $k => $v) {
            if (\strncasecmp($k, 'x-oss-meta-', 11) == 0) {
                $result[substr($k, 11)] = $v;
            }
        }
        return empty($result) ? null : $result;
    }

    public static function addContentType(RequestModel $request, OperationInput $input)
    {
        if ($input->hasHeader('Content-Type')) {
            return;
        }
        $value = Utils::guessContentType($input->getKey());
        if ($value != null) {
            $input->setHeader('Content-Type', $value);
        }
    }

    public static function addContentMd5(RequestModel $request, OperationInput $input)
    {
        if ($input->hasHeader('Content-MD5')) {
            return;
        }

        $value = '1B2M2Y8AsgTpgAmY7PhCfg==';
        if ($input->getBody() != null) {
            $value = Utils::calcContentMd5($input->getBody());
        }
        $input->setHeader('Content-MD5', $value);
    }
}