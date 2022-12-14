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
    public const EMAIL_USER_DELETE = 4;
    public const EMAIL_USER_ADD_ADMIN = 5;

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
        $this->setEncoding();
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
                $this->body = $htmlBody;
                $this->Body = $this->body;
                $this->AltBody = $this->body;
                $this->send();
            }catch(Exception $e){
                /* echo "Mail Exception => ".$e->getMessage()."\r\n";
                echo "Mail error => {$this->ErrorInfo}\r\n"; */
                $this->errno = Eme::ERR_EMAIL_SEND;
            }
        }//if(isset($data['code'],$data['link'],$data['verifyUrl']) && $data['code'] != '' && $data['link'] != '' && $data['verifyUrl'] != ''){
        else throw new NotSettedException(Eme::EXC_NOTISSET);
    }

    /**
     * Send an email to the user that administrator has added to the newsletter
     */
    public function sendAddUserNotify(array $data){
        $this->errno = 0;
        if(isset($data['lang']) && $data['lang'] != ''){
            try{
                $lang = $data['lang'];
                $templateData = ['from' => $this->from ];
                $htmlBody = Template::addUserAdminTemplate($lang, $templateData);
                $this->addAddress($this->email);
                $subject = Template::addUserAdminMessages($lang,$templateData)["title"];
                $this->subject = $subject;
                $this->body = $htmlBody;
                $this->Subject = $this->subject;
                $this->Body = $this->body;
                $this->AltBody = $this->body;
                $this->send();
            }
            catch(Exception $e){
                $this->errno = Eme::ERR_EMAIL_SEND;
            }
        }//if(isset($data['lang']) && $data['lang'] != ''){
        else throw new NotSettedException(Eme::EXC_NOTISSET);
    }

    /**
     * Send an email to the used that was deleted from the newsletter by the admin
     */
    public function sendDeleteUserNotify(){
        $this->errno = 0;
        foreach($this->emailsList as $email){
            $addresses = $this->getAllRecipientAddresses();
            if(!empty($addresses))$this->clearAddresses();
            try{
                $user = $this->checkSubscribedEmail($email);
                if($user != null){
                    $del = $this->userDelete($user);
                    if($del){
                        $this->addAddress($email);
                        $lang = $user->getLang();
                        $templateData = ['from' => $this->from];
                        $subject = Template::deleteUserMessages($lang,$templateData)["title"];
                        $htmlBody = Template::deleteUserTemplate($lang,$templateData);
                        $this->subject = $subject;
                        $this->body = $htmlBody;
                        //echo "EmailManager sendUserDeleteNotify body => ".var_export($this->body,true)."\r\n";
                        $this->Subject = $this->subject;
                        $this->Body = $this->body;
                        $this->AltBody = $this->body;
                        $this->send();
                    }//if($del){ 
                }//if($user != null){
            }catch(Exception $e){
                //echo "Mail Exception => ".$e->getMessage()."\r\n";
                $this->errno = Eme::ERR_EMAIL_SEND;
            }
        }//foreach($this->emailsList as $email){
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
                    $this->body = $htmlBody;
                    $this->Body = $this->body;
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
            $this->body = $htmlBody;
            $this->Body = $this->body;
            $this->AltBody = "L'utente con email {$this->email} si è cancellato dalla newsletter";
            $this->send();
        }catch(Exception $e){
            //echo "Mail Exception => ".$e->getMessage()."\r\n";
            $this->errno = Eme::ERR_EMAIL_SEND;
        }
    }

}

?>