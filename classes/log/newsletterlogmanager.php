<?php

namespace Newsletter\Classes\Log;
use Newsletter\Traits\ErrorTrait;

/**
 * Class to retrieve the newsletter log info file
 */
class NewsletterLogManager{

    use ErrorTrait;

    private array $loginfo = [];

    public function getLogInfo(){ return $this->loginfo; }
}
?>