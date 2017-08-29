<?php

namespace App\Exceptions;

use Tymon\JWTAuth\Exceptions\JWTException;

class InvalidCredentialsException extends JWTException
{
    /**
     * @var int
     */
    protected $statusCode = 401;

}