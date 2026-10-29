<?php

namespace UnitTests;

use AlibabaCloud\Oss\V2\Copier;
use AlibabaCloud\Oss\V2\Models\CopyObjectRequest;
use AlibabaCloud\Oss\V2\Models\GetObjectTaggingResult;
use AlibabaCloud\Oss\V2\Models\InitiateMultipartUploadRequest;
use AlibabaCloud\Oss\V2\Models\Tag;
use AlibabaCloud\Oss\V2\Models\TagSet;

class CopierTest extends \PHPUnit\Framework\TestCase
{
    public function testOverwriteTagPropUrlEncodesKeysAndValues()
    {
        $request = new CopyObjectRequest();
        $request->bucket = 'dst-bucket';
        $request->key = 'dst-key';
        $request->sourceBucket = 'src-bucket';
        $request->sourceKey = 'src-key';
        $request->taggingDirective = 'COPY';

        $tagProp = new GetObjectTaggingResult(
            tagSet: new TagSet(tags: [
                new Tag(key: 'a=b', value: 'c+d'),
                new Tag(key: 'key with space', value: 'value+with=special'),
            ])
        );

        $context = [
            'request' => $request,
            'tag_prop' => $tagProp,
        ];

        $imRequest = new InitiateMultipartUploadRequest();

        $method = new \ReflectionMethod(Copier::class, 'overwirteTagProp');
        $method->setAccessible(true);
        $method->invokeArgs(null, [&$imRequest, &$context]);

        $this->assertEquals(
            'a%3Db=c%2Bd&key%20with%20space=value%2Bwith%3Dspecial',
            $imRequest->tagging
        );
    }
}
