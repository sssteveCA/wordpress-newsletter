<?php

namespace Newsletter\Exceptions;

use Exception;
use Newsletter\Traits\ExceptionTrait;
use Throwable;

/**
 * Exception thrown when the variable has not the expected format
 */
class IncorrectVariableFormatException extends Exception{

    use ExceptionTrait;
}
?>