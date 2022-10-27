<?php

namespace Newsletter\Classes\Email;

use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;
use Newsletter\Traits\EmailManagerTrait;
use PHPMailer\PHPMailer\PHPMailer;

interface EmailManagerErrors extends ExceptionMessages{

}

/**
 * This class is used to send emails to newsletter subscribers
 */
class EmailManager extends PHPMailer{

    use EmailManagerTrait;

    private array $usersList;
    private array $emailsList;
    private string $emailAddress;
    private string $password;
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

}

?>