<?php

namespace App\Http\DTO\ApiResponses;

class StatusResponse extends BaseResponse
{
    public $status;

    public function __construct($result)
    {
        $this->status = $result ? 'success' : 'fail';
    }
}