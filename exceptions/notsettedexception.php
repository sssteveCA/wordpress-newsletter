<?php

namespace Newsletter\Exceptions;

use Newsletter\Traits\ExceptionTrait;
use Throwable;

class NotSettedException extends \Exception{

    use ExceptionTrait;
}
?>