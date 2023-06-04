<?php

namespace Newsletter\Exceptions;
use Exception;
use Newsletter\Traits\ExceptionTrait;
use Throwable;

/**
 * Exception thrown when the server can't get the required data from DB
 */
class DataNotRetrievedException extends Exception{
    use ExceptionTrait;
}

?>