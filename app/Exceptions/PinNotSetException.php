<?php

namespace App\Exceptions;

use Exception;

class PinNotSetException extends Exception
{
    public function __construct(string $message){
        parent::__construct( $message);
    }
}
