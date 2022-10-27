<?php

namespace Newsletter\Classes\Email;

use Exception;
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
        $this->setServerSettings($data);
        $this->setRecipients($data);
        $this->setContent();
    }

    public function getEmailsList(){ return $this->emailsList; }
    public function getUsersList(){ return $this->usersList; }
    public function getSubject(){ return $this->subject; }
    public function getBody(){ return $this->body; }

    /**
     * Send the newletter to indicated subscribers
     */
    public function sendNewsletterEmail(){
        $this->errno = 0;
        foreach($this->emailsList as $email){
            try{
                $user = $this->checkSubscribedEmail($email);
                if($user != null){

                }//if($user != null){
            }catch(Exception $e){

            }
            
        }//foreach($this->emailsList as $email){

    }

    

}

?>