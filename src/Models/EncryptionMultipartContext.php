<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

/**
 * Class EncryptionMultipartContext
 * @package AlibabaCloud\Oss\V2\Models
 */
class EncryptionMultipartContext
{
    /**
     * The content cipher used to encrypt each part in the multipart upload.
     * @var \AlibabaCloud\Oss\V2\Crypto\ContentCipherInterface;
     */
    public $contentCipher;

    /**
     * The total size of the multipart upload data.
     * @var int|null
     */
    public ?int $dataSize;

    /**
     * The size of each part in the multipart upload.
     * @var int|null
     */
    public ?int $partSize;

    /**
     * Constructor to initialize the EncryptionMultiPartContext.
     *
     * @param \AlibabaCloud\Oss\V2\Crypto\ContentCipherInterface|null $contentCipher
     * @param int|null $dataSize
     * @param int|null $partSize
     */
    public function __construct(
        ?\AlibabaCloud\Oss\V2\Crypto\ContentCipherInterface $contentCipher = null,
        ?int $dataSize = null,
        ?int $partSize = null
    )
    {
        $this->contentCipher = $contentCipher;
        $this->dataSize = $dataSize;
        $this->partSize = $partSize;
    }

    /**
     * @return bool
     */
    public function valid()
    {
        if ($this->contentCipher === null || $this->dataSize === 0 || $this->partSize === 0) {
            return false;
        }
        return true;
    }
}
