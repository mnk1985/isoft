<?php

namespace App\Http\DTO\ApiResponses;

class ErrorResponse extends BaseResponse
{
    public $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }
}