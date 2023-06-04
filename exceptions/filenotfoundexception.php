<?php

namespace Newsletter\Exceptions;

use Exception;
use Newsletter\Traits\ExceptionTrait;
use Throwable;

class FileNotFoundException extends Exception{
    use ExceptionTrait;
}
?>