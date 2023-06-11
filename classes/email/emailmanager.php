<?php

namespace Newsletter\Classes\Email;

use Exception;
use Newsletter\Classes\Database\Models\Settings;
use Newsletter\Classes\Log\NewsletterLogManager;
use Newsletter\Classes\Models\NewsletterLogInfo;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;
use Newsletter\Classes\Template;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Traits\EmailManagerTrait;
use Newsletter\Traits\ErrorTrait;
use PHPMailer\PHPMailer\PHPMailer;
use Newsletter\Interfaces\Constants as C;

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
    public const EMAIL_NEW_SUBSCRIBER = 6;

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
                $this->addAddress($this->email);
                $this->body = Template::activationMailTemplate($lang,$templateData);
                $this->Body = $this->body;
                $this->AltBody = $this->body;
                $this->send();
            }catch(Exception $e){
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
                $this->addAddress($this->email);
                $this->subject = Template::addUserAdminMessages($lang,$templateData)["title"];
                $this->body = Template::addUserAdminTemplate($lang, $templateData);
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
     * Send an email to the users that was deleted from the newsletter by the admin
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
                        $this->subject = Template::deleteUserMessages($lang,$templateData)["title"];
                        $this->body = Template::deleteUserTemplate($lang,$templateData);
                        $this->Subject = $this->subject;
                        $this->Body = $this->body;
                        $this->AltBody = $this->body;
                        $this->send();
                    }//if($del){ 
                }//if($user != null){
            }catch(Exception $e){
                $this->errno = Eme::ERR_EMAIL_SEND;
            }
        }//foreach($this->emailsList as $email){
    }

    /**
     * Send the newletter to indicated subscribers
     * @throws Exception
     */
    public function sendNewsletterMail(){
        $this->errno = 0;
        $log_data = [];
        $settings = new Settings(['tableName' => C::TABLE_SETTINGS]);
        if($settings->getSettings()){
            foreach($this->emailsList as $email){
                try{
                    $addresses = $this->getAllRecipientAddresses();
                    if(!empty($addresses))$this->clearAddresses();
                    $user = $this->checkSubscribedEmail($email);
                    if($user != null){
                        $lang = $user->getLang();
                        if($settings->getLangStatus()[$lang]){
                            $templateData = [
                                'title' => $this->subject, 'user_email' => $email,
                                'text' => $this->body, 'unsubscribe_code' => $user->getUnsubscCode(),
                                'settings' => [
                                    'included_pages_status' => $settings->getIncludedPagesStatus(),
                                    'socials_status' => $settings->getSocialsStatus(),
                                    'social_pages' => $settings->getSocialPages(),
                                    'contact_pages' => $settings->getContactPages(),
                                    'privacy_policy_pages' => $settings->getPrivacyPolicyPages()
                                ]
                            ];
                            $htmlBody = Template::mailTemplate($lang,$templateData);
                            $this->addAddress($email);
                            $this->Body = $htmlBody;
                            $this->AltBody = $this->body;
                            $this->send();
                            $log_data[] = new NewsletterLogInfo($this->subject,$email,date('Y-m-d'),true);
                        }//if($settings->getLangStatus()[$user_lang]){
                    }//if($user != null){    
                }catch(Exception $e){
                    $log_data[] = new NewsletterLogInfo($this->subject,$email,date('Y-m-d'),false);
                }
            }//foreach($this->emailsList as $email){
            $log_path = sprintf("%s/newsletter%s",WP_PLUGIN_DIR,C::REL_NEWSLETTER_LOG);
            $nlm = new NewsletterLogManager($log_path);
            $nlm->writeFile($log_data);
        }//if($settings->getSettings()){
        else throw new Exception;
    }

    /**
     * Receive a notification when a new user has subscribed to the newsletter
     */
    public function sendNewSubscriberNotify(){
        $this->errno = 0;
        try{
            $this->addAddress($this->from);
            $this->body = Template::newSubscriberTemplate($this->email);
            $this->Body = $this->body;
            $this->AltBody = "L'utente con email {$this->email} si è iscritto alla newsletter";
            $this->send();
        }
        catch(Exception $e){
            $this->errno = Eme::ERR_EMAIL_SEND;
        }
    }

    /**
     * Receive a notification on your email address when an user unsubscribe from your newsletter
     */
    public function sendUserUnsubscribeNotify(){
        $this->errno = 0;
        try{
            $this->addAddress($this->from);
            $this->body = Template::unsubscribedUserTemplate($this->email);
            $this->Body = $this->body;
            $this->AltBody = "L'utente con email {$this->email} si è cancellato dalla newsletter";
            $this->send();
        }catch(Exception $e){
            $this->errno = Eme::ERR_EMAIL_SEND;
        }
    }

}

?>