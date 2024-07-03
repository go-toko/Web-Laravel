<?php

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    public function __construct($message, $code = 500)
    {
        parent::__construct($message, $code);
    }
}
