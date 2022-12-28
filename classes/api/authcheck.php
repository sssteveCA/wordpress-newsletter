<?php

namespace Newsletter\Classes\Api;

use Newsletter\Exceptions\NotSettedException;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Interfaces\ExceptionMessages as Em;

class AuthCheck{
    use ErrorTrait;

    private string $username;
    private string $password;

    public function __construct(array $data)
    {
        $this->checkData($data);
    }

    public function getError(){
        switch($this->errno){
            default:
                $this->error = null;
        }
        return $this->error;
    }

    /**
     * Check if username and password values exists and aren't empty
     */
    private function checkData(array $data){
        if(!isset($data["username"],$data["password"])) throw new NotSettedException(Em::EXC_INSERT_CREDENTIALS);
        $usernameTrim = trim($data["username"]);
        $passwordTrim = trim($data["password"]);
        if(!($usernameTrim != "" && $passwordTrim != "")) throw new NotSettedException(Em::EXC_INSERT_CREDENTIALS);
        $this->username = $usernameTrim;
        $this->password = $passwordTrim; 
    }
}
?>