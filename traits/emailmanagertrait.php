<?php

namespace Newsletter\Traits;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Exceptions\NotSettedException;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Newsletter\Interfaces\Constants as C;
use Newsletter\Classes\Email\EmailManagerErrors as Eme;

trait EmailManagerTrait{

    private function assignValues(array $data){
        if(isset($data['body'],$data['emails'],$data['from'],$data['host'],$data['password'], $data['port'],$data['subject'])){
            $this->emailsList = $data['emails'];
            $this->subject = $data['subject'];
            $this->body = $data['body'];
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
        $this->AltBody = $this->body;
    }

    private function setRecipients(array $data){
        $this->setFrom($data['from']);
        $this->addReplyTo($data['from']);
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

    
}
?>