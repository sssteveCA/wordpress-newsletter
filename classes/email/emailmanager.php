<?php

namespace Newsletter\Classes\Email;

use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;
use Newsletter\Traits\EmailManagerTrait;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

interface EmailManagerErrors extends ExceptionMessages{

}

/**
 * This class is used to send emails to newsletter subscribers
 */
class EmailManager extends PHPMailer{

    use EmailManagerTrait;

    private array $usersList;
    private array $emailsList;
    private string $subject;
    private string $body;

    public function __construct(array $data)
    {
        parent::__construct();
        $this->assignValues($data);
    }

    public function getEmailsList(){ return $this->emailsList; }
    public function getUsersList(){ return $this->usersList; }
    public function getSubject(){ return $this->subject; }
    public function getBody(){ return $this->body; }

    private function setServerSettings(array $data){
        $this->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->isSMTP();
        $this->Host = "";
        $this->SMTPAuth = true;
        $this->Username = $data['from'];
        $this->Password = $data['password'];
        $this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->Port = 465;
    }

}

?>