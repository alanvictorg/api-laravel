<?php

namespace App\Exceptions;


use Tymon\JWTAuth\Exceptions\JWTException;

class CouldNotCreateTokenException extends JWTException
{

    /**
     * @var int
     */
    protected $statusCode = 500;

}