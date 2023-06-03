<?php

namespace Newsletter\Traits;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\Email\EmailManager;
use Newsletter\Exceptions\NotSettedException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;

trait EmailManagerTrait{

    private function assignValues(array $data){
        if(isset($data['from'],$data['fromNickname'],$data['host'],$data['password'], $data['port'])){
            $this->from = $data['from'];
            $this->fromNickname = $data['fromNickname'];
            $operation = isset($data['operation']) ? $data['operation'] : EmailManager::EMAIL_NEWSLETTER;
            $operation_test_1 = ($operation == EmailManager::EMAIL_ACTIVATION || $operation == EmailManager::EMAIL_USER_UNSUBCRIBE);
            $operation_test_2 = ($operation == EmailManager::EMAIL_USER_ADD_ADMIN || $operation == EmailManager::EMAIL_NEW_SUBSCRIBER);
            if($operation_test_1 || $operation_test_2){
                if(isset($data['email'],$data['subject'])){
                    $this->email = $data['email'];
                    $this->subject = $data['subject'];
                }
                else throw new NotSettedException(Eme::EXC_NOTISSET);
            }
            else{
                if(isset($data['body'],$data['emails'],$data['subject'])){
                    $this->emailsList = $data['emails'];
                    $this->subject = $data['subject'];
                    $this->body = $data['body'];
                }
                else throw new NotSettedException(Eme::EXC_NOTISSET);
            }     
        }
        else throw new NotSettedException(Eme::EXC_NOTISSET);
        
    }

    /**
     * Check if email provided is a newsletter subscribed email
     * @param string $email the email to check
     * @return User the User object associated with the provided email, null if no user found
     */
    private function checkSubscribedEmail(string $email): ?User{
        $user = new User([
            'tableName' => C::TABLE_USERS
        ]);
        $sql = "WHERE `".User::$fields["email"]."` = %s AND `".User::$fields["subscribed"]."` = 1";
        $values = [$email];
        $user->getUser($sql,$values);
        $userE = $user->getErrno();
        if($userE == 0) return $user;
        return null;
    }

    private function setContent(){
        $this->isHTML(true);
        $this->Subject = $this->subject;
    }

    private function setEncoding(){
        $this->CharSet = 'UTF-8';
        $this->Encoding = 'base64';
    }

    private function setRecipients(array $data){
        $this->setFrom($this->from, $this->fromNickname);
        $this->addReplyTo($this->from);
    }

    private function setServerSettings(array $data){
        $this->SMTPDebug = SMTP::DEBUG_OFF;
        //$this->SMTPDebug = SMTP::DEBUG_SERVER;
        $this->isSMTP();
        $this->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true
            ]
        ];
        $this->Host = $data['host'];
        $this->SMTPAuth = true;
        $this->Username = $data['from'];
        $this->Password = $data['password'];
        //$this->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        //$this->SMTPSecure = false;
    }

    /**
     * Delete the user before send the mail
     * @param User $user the user to delete
     * @return bool true if user was deleted, false otherwise
     */
    private function userDelete(User $user): bool{
        $sql = "WHERE `".User::$fields["email"]."` = %s";
        $values = [$user->getEmail()];
        $user->deleteUser($sql,$values);
        if($user->getErrno() == 0) return true;
        return false;
    }

    
}
?>