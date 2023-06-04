<?php

namespace Newsletter\Exceptions;

use Exception;
use Newsletter\Traits\ExceptionTrait;
use Throwable;

/**
 * This exception is thrown when the client authentication fails
 */
class WrongCredentialsException extends Exception{

    use ExceptionTrait;
}
?>