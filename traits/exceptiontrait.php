<?php

namespace Newsletter\Traits;

use Throwable;

/**
 * This trait contains the base for all extended exception classes
 */
trait ExceptionTrait{
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