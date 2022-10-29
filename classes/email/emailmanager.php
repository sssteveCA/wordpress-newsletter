<?php

namespace Newsletter\Classes\Email;

use Exception;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;
use Newsletter\Classes\Properties;
use Newsletter\Classes\Template;
use Newsletter\Exceptions\NotSettedException;
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

    public const EMAIL_NEWSLETTER = 1;
    public const EMAIL_ACTIVATION = 2;
    public const EMAIL_USER_UNSUBCRIBE = 3;

    private string $email;
    private string $from;
    private string $fromNickname;
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

    public function getEmail(){ return $this->email; }
    public function getFrom(){ return $this->from; }
    public function getFromNickname(){ return $this->fromNickname; }
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
     * Send the activation mail for new subscriber
     */
    public function sendActivationMail(array $data){
        $this->errno = 0;
        if(isset($data['verCode'],$data['lang'],$data['link'],$data['verifyUrl']) && $data['verCode'] != '' && $data['link'] != '' && $data['verifyUrl'] != ''){
            try{
                $lang = $data['lang'];
                $templateData = [
                    'verCode' => $data['verCode'], 'link' => $data['link'], 'verifyUrl' => $data['verifyUrl']
                ];
                $htmlBody = Template::activationMailTemplate($lang,$templateData);
                $this->addAddress($this->email);
                $this->Body = $htmlBody;
                $this->AltBody = "Siamo spiacenti il tuo client di posta non supporta l'HTML";
                $this->send();
            }catch(Exception $e){
                //echo "Mail Exception => ".$e->getMessage()."\r\n";
                $this->errno = Eme::ERR_EMAIL_SEND;
            }
        }//if(isset($data['code'],$data['link'],$data['verifyUrl']) && $data['code'] != '' && $data['link'] != '' && $data['verifyUrl'] != ''){
        else throw new NotSettedException(Eme::EXC_NOTISSET);
    }

    /**
     * Send the newletter to indicated subscribers
     */
    public function sendNewsletterMail(){
        $this->errno = 0;
        foreach($this->emailsList as $email){
            $addresses = $this->getAllRecipientAddresses();
            if(!empty($addresses))$this->clearAddresses();
            try{
                $user = $this->checkSubscribedEmail($email);
                if($user != null){
                    $templateData = [
                        'title' => $this->subject, 'user_email' => $email,
                        'text' => $this->body, 'unsubscribe_code' => $user->getUnsubscCode()
                    ];
                    //echo "\r\n EmailManager sendNewsletterEmail template data => ".var_export($templateData,true)."\r\n";
                    $lang = $user->getLang();
                    $htmlBody = Template::mailTemplate($lang,$templateData);
                    $this->addAddress($email);
                    $this->Body = $htmlBody;
                    $this->AltBody = $this->body;
                    $this->send();
                }//if($user != null){
            }catch(Exception $e){
                //echo "Mail Exception => ".$e->getMessage()."\r\n";
                $this->errno = Eme::ERR_EMAIL_SEND;
            }      
        }//foreach($this->emailsList as $email){
    }

    /**
     * Receive a notification on your email address when an user unsubscribe from your newsletter
     */
    public function sendUserUnsubscribeNotify(){
        $this->errno = 0;
        try{
            $htmlBody = Template::unsubscribedUserTemplate($this->email);
            //echo "EmailManager sendUserUnsubscribeNotify htmlBody => ".var_export($htmlBody,true)."\r\n";
            $this->addAddress($this->from);
            $this->Body = $htmlBody;
            $this->AltBody = "L'utente con email {$this->email} si è cancellato dalla newsletter";
            $this->send();
        }catch(Exception $e){
            //echo "Mail Exception => ".$e->getMessage()."\r\n";
            $this->errno = Eme::ERR_EMAIL_SEND;
        }
    }

}

?>