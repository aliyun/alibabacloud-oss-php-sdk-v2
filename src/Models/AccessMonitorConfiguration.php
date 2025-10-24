<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class AccessMonitorConfiguration
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'AccessMonitorConfiguration')]
final class AccessMonitorConfiguration extends Model
{
    /**
     * The access tracking status of the bucket. Valid values:- Enabled: Access tracking is enabled.- Disabled: Access tracking is disabled.
     * Sees AccessMonitorStatusType for supported values.
     * @var string|null
     */
    #[XmlElement(rename: 'Status', type: 'string')]
    public ?string $status;

    /**
     * Only effective when Status is Enabled, indicating whether it supports updating the source data's LastAccesstime when CopyObject/UploadPartCopy is used.
     * @var bool|null
     */
    #[XmlElement(rename: 'AllowCopy', type: 'bool')]
    public ?bool $allowCopy;

    /**
     * AccessMonitorConfiguration constructor.
     * @param string|null $status The access tracking status of the bucket.
     * @param bool|null $allowCopy Only effective when Status is Enabled, indicating whether it supports updating the source data's LastAccesstime when CopyObject/UploadPartCopy is used
     */
    public function __construct(
        ?string $status = null,
        ?bool $allowCopy = null
    )
    {
        $this->status = $status;
        $this->allowCopy = $allowCopy;
    }
}