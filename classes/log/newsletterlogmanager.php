<?php

namespace Newsletter\Classes\Log;

use Newsletter\Traits\ErrorTrait;
use Newsletter\Classes\Log\NewsletterLogManagerErrors as Nlme;

interface NewsletterLogManagerErrors{
    const ERR_FILE_NOT_FOUND = 1;

    const ERR_FILE_NOT_FOUND_MSG = "Impossibile aprire il file di log";
}

/**
 * Class to retrieve the newsletter log info file
 */
class NewsletterLogManager implements Nlme{

    use ErrorTrait;

    private array $loginfo = [];

    public function getLogInfo(){ return $this->loginfo; }
    public function getError(){
        switch($this->errno){
            case Nlme::ERR_FILE_NOT_FOUND:
                $this->error = Nlme::ERR_FILE_NOT_FOUND_MSG;
                break;
            default:
                $this->error = null;
        }
        return $this->error;
    }
}
?>