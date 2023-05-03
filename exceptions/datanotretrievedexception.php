<?php

namespace Newsletter\Exceptions;
use Exception;
use Throwable;

/**
 * Exception thrown when the server can't get the required data from DB
 */
class DataNotRetrievedException extends Exception{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string
    {
        return __CLASS__.": [{$this->code}]: {$this->message}\n";
    }
}

?>