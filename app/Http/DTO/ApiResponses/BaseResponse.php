<?php

namespace App\Http\DTO\ApiResponses;

class BaseResponse
{
    public function __toString()
    {
        return json_encode(get_object_vars($this));
    }
}