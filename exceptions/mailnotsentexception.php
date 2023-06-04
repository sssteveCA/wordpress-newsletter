<?php

namespace Newsletter\Exceptions;

use Exception;
use Newsletter\Traits\ExceptionTrait;
use Throwable;

class MailNotSentException extends Exception{
    use ExceptionTrait;
}
?>