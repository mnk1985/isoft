<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\JWTAuth;

abstract class BaseApiController extends Controller
{
    /**
     * @return JWTAuth
     */
    protected function getAuth()
    {
        return auth('api');
    }

    /**
     * @return User
     */
    protected function getUser(): JWTSubject
    {
        return $this->getAuth()->user();
    }
}