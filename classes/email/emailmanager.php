<?php

namespace Newsletter\Classes\Email;

use Exception;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;
use Newsletter\Classes\Template;
use Newsletter\Traits\EmailManagerTrait;
use Newsletter\Traits\ErrorTrait;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

interface EmailManagerErrors extends ExceptionMessages{
    const ERR_EMAIL_SEND = 1;

    const ERR_EMAIL_SEND_MSG = "C'è stato un errore durante l'invio della mail a uno o più destinatari";
}

/**
 * This class is used to send emails to newsletter subscribers
 */
class EmailManager extends PHPMailer{

    use EmailManagerTrait, ErrorTrait;

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
    public function getSubject(){ return $this->subject; }
    public function getBody(){ return $this->body; }
    public function getError(){
        switch($this->errno){
            case Eme::ERR_EMAIL_SEND:
                $this->error = Eme::ERR_EMAIL_SEND_MSG;
                break;
            default:
                $this->error = null;
                break;
        }
    }

    /**
     * Send the newletter to indicated subscribers
     */
    public function sendNewsletterEmail(){
        $this->errno = 0;
        foreach($this->emailsList as $email){
            $addresses = $this->getAllRecipientAddresses();
            if(!empty($addresses))$this->clearAddresses();
            try{
                $user = $this->checkSubscribedEmail($email);
                if($user != null){
                    $template_data = [
                        'title' => $this->subject,
                        'user_email' => $email,
                        'text' => $this->body,
                        'unsubscribed_url' => $user->getUnsubscCode()
                    ];
                    $lang = $user->getLang();
                    $htmlBody = Template::mailTemplate($lang,$template_data);
                    $this->addAddress($email);
                    $this->Body = $htmlBody;
                    $this->send();
                }//if($user != null){
            }catch(Exception $e){
                echo "Mail Exception => ".$e->getMessage()."\r\n";
                $this->errno = Eme::ERR_EMAIL_SEND;
            }      
        }//foreach($this->emailsList as $email){
    }

}

?>