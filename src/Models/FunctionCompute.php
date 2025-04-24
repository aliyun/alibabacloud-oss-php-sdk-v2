<?php

declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\Model;
use AlibabaCloud\Oss\V2\Annotation\XmlElement;
use AlibabaCloud\Oss\V2\Annotation\XmlRoot;

/**
 * Class FunctionCompute
 * @package AlibabaCloud\Oss\V2\Models
 */
#[XmlRoot(name: 'FunctionCompute')]
final class FunctionCompute extends Model
{   
    /**
     * The Alibaba Cloud Resource Name (ARN) of the role that Function Compute uses to access your resources in other cloud services. The default role is AliyunFCDefaultRole.
     * @var string|null
     */
    #[XmlElement(rename: 'FunctionAssumeRoleArn', type: 'string')]
    public ?string $functionAssumeRoleArn;
    /**
     * The ARN of the function. For more information,
     * @var string|null
     */
    #[XmlElement(rename: 'FunctionArn', type: 'string')]
    public ?string $functionArn;

    /**
     * FunctionCompute constructor.
     * @param string|null $functionAssumeRoleArn The Alibaba Cloud Resource Name (ARN) of the role that Function Compute uses to access your resources in other cloud services.
     * @param string|null $functionArn The ARN of the function.
     */
    public function __construct(
        ?string $functionAssumeRoleArn = null,
        ?string $functionArn = null
    )
    {   
        $this->functionAssumeRoleArn = $functionAssumeRoleArn;
        $this->functionArn = $functionArn;
    }
}