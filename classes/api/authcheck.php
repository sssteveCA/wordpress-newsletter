<?php

namespace Newsletter\Classes\Api;

use Newsletter\Exceptions\NotSettedException;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Interfaces\ExceptionMessages as Em;
use Newsletter\Classes\Api\AuthCheckErrors as Ace;
use WP_Application_Passwords;

interface AuthCheckErrors{
    const INVALID_USERNAME = 1;
    const WRONG_PASSWORD = 2;

    const INVALID_USERNAME_MSG = "Nome utente non trovato";
    const WRONG_PASSWORD_MSG = "Password errata";
}

/**
 * Match the provided data with the Application Wordpress credentials
 */
class AuthCheck implements Ace{
    use ErrorTrait;

    private string $username;
    private string $password;
    private string $uuid;

    public function __construct(array $data)
    {
        $this->checkData($data);
        $this->verifyCredentials();
    }

    public function getError(){
        switch($this->errno){
            case Ace::INVALID_USERNAME:
                $this->error = Ace::INVALID_USERNAME_MSG;
                break;
            case Ace::WRONG_PASSWORD:
                $this->error = Ace::WRONG_PASSWORD_MSG;
                break;
            default:
                $this->error = null;
                break;
        }
        return $this->error;
    }

    /**
     * Check if username and password values exists and aren't empty
     */
    private function checkData(array $data){
        if(!isset($data["username"],$data["password"],$data["uuid"])) throw new NotSettedException(Em::EXC_INSERT_CREDENTIALS);
        $usernameTrim = trim($data["username"]);
        $passwordTrim = trim($data["password"]);
        $uuidTrim = trim($data["uuid"]);
        if(!($usernameTrim != "" && $passwordTrim != "" && $uuidTrim != "")) throw new NotSettedException(Em::EXC_INSERT_CREDENTIALS);
        $this->username = $usernameTrim;
        $this->password = $passwordTrim;
        $this->uuid = $uuidTrim;
    }

    /**
     * Check if the provided credentials are valid
     */
    private function verifyCredentials(): bool{
        $user = get_user_by('login',$this->username);
        if($user){
            $ap = new WP_Application_Passwords();
            $pwd = $ap->get_user_application_password($user->ID, $this->uuid);
            if($pwd)
                return true;
            else $this->error = Ace::WRONG_PASSWORD;
        }//if(get_user_by('login',$this->username)){
        else $this->errno = Ace::INVALID_USERNAME;
        return false;
    }
}
?>