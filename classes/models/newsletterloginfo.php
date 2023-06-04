<?php

namespace Newsletter\Classes\Models;
use Newsletter\Traits\ErrorTrait;

/**
 * This class represents the single newsletter log file item
 */
class NewsletterLogInfo{

    use ErrorTrait;

    private string $subject;
    private string $recipient;
    private string $date;

    public function __construct(string $subject,string $recipient,string $date){
        $this->subject = $subject;
        $this->recipient = $recipient;
        $this->date = $date;
    }

    public function getSubject(){return $this->subject;}
    public function getRecipient(){return $this->recipient;}
    public function getDate(){return $this->date;}
}
?>