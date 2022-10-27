<?php

namespace Newsletter\Traits;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

trait EmailManagerTrait{

    private function assignValues(array $data){
        $this->emailsList = $data['emails'];
        $this->subject = $data['subject'];
        $this->body = $data['body'];
    }

    private function setServerSettings(array $data){
        $this->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->isSMTP();
        $this->Host = $data['host'];
        $this->SMTPAuth = true;
        $this->Username = $data['from'];
        $this->Password = $data['password'];
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->Port = $data['port'];
    }

    private function setRecipients(array $data){
        $this->setFrom($data['from']);
        $this->addReplyTo($data['from']);
    }

    private function setContent(){
        $this->isHTML(true);
        $this->Subject = $this->subject;
        $this->AltBody = $this->body;
    }
}
?>