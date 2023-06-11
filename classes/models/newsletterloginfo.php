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
    private bool $sended;

    public function __construct(string $subject,string $recipient,string $date, bool $sended){
        $this->subject = $subject;
        $this->recipient = $recipient;
        $this->date = $date;
        $this->sended = $sended;
    }

    public function getSubject(){return $this->subject;}
    public function getRecipient(){return $this->recipient;}
    public function getDate(){return $this->date;}
    public function wasSended(){return $this->sended;}
}
?>