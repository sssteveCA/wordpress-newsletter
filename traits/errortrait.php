<?php

namespace Newsletter\Traits;

trait ErrorTrait{

    /**
     * Error code generated inside the class
     */
    protected int $errno = 0;

    /**
     * Error message associated with the error code
     */
    protected ?string $error = null;

    public function getErrno(){return $this->errno;}
}
?>