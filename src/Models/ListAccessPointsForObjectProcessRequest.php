<?php
declare(strict_types=1);

namespace AlibabaCloud\Oss\V2\Models;

use AlibabaCloud\Oss\V2\Types\RequestModel;
use AlibabaCloud\Oss\V2\Annotation\TagProperty;

/**
 * The request for the ListAccessPointsForObjectProcess operation.
 * Class ListAccessPointsForObjectProcessRequest
 * @package AlibabaCloud\Oss\V2\Models
 */
final class ListAccessPointsForObjectProcessRequest extends RequestModel
{   

    /** 
     * The maximum number of Object FC Access Points to return.Valid values: 1 to 1000 If the list cannot be complete at a time due to the configurations of the max-keys element, the NextContinuationToken element is included in the response as the token for the next list.
     * @var int|null
     */
    #[TagProperty(tag: '', position: 'query', rename: 'max-keys', type: 'int')]
    public ?int $maxKeys;

    /** 
     * The token from which the list operation must start. You can obtain this token from the NextContinuationToken element in the returned result.
     * @var string|null
     */
    #[TagProperty(tag: '', position: 'query', rename: 'continuation-token', type: 'string')]
    public ?string $continuationToken;

    /**
     * ListAccessPointsForObjectProcessRequest constructor.
     * 
     * @param int|null $maxKeys The maximum number of Object FC Access Points to return.
     * @param string|null $continuationToken The token from which the list operation must start.
     * @param array|null $options
     */
    public function __construct( 
        ?int $maxKeys = null,
        ?string $continuationToken = null,
        ?array $options = null
    )
    {   
        $this->maxKeys = $maxKeys;
        $this->continuationToken = $continuationToken;
        parent::__construct($options);
    }
}