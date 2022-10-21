<?php

namespace Newsletter\Classes\Subscribe;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\Properties;
use Newsletter\Exceptions\IncorrectVariableFormatException;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Classes\Subscribe\UserSubscribeError as Usee;
use Newsletter\Traits\ErrorTrait;

interface UserSubscribeError extends ExceptionMessages{
    const FROM_USER = 1;
    const INCORRECT_EMAIL = 2;

    const FROM_USER_MSG = "Errore dall'oggetto User";
    const INCORRECT_EMAIL_MSG = "L' indirizzo email inserito non è in un formato valido";
}

class UserSubscribe implements Usee{

    use ErrorTrait;

    private ?User $user;
    private string $userLang;

    public static array $regex = [
        'email' => '/^[a-zA-Z-_\.0-9]{4,40}@([a-z]{3,25}\.){1,6}[a-z]{2,10}$/',
        //'email' => '/^[a-zA-Z-_0-9]{4,20}@([a-z]{3,15}\.){1,6}[a-z]{2,10}$/',
    ];

    public function __construct(array $data)
    {
        $this->checkValues($data);
        $this->insertUser();
    }

    public function getUser(){return $this->user;}
    public function getUserLang(){return $this->userLang;}
    public function getError(){
        switch($this->errno){
            case Usee::FROM_USER:
                $this->error = Usee::FROM_USER_MSG;
                break;
            case Usee::INCORRECT_EMAIL:
                $this->error = Usee::INCORRECT_EMAIL_MSG;
                break;
            default:
                $this->error = null;
                break;
        }
    }

    private function checkValues(array $data){
        if(!isset($data['lang'])) $data['lang'] = 'en';
        $this->userLang = $data['lang'];
        if(!isset($data['user'])){
            $message = Properties::unknownError($this->userLang);
            throw new NotSettedException($message);
        }
        if(!$data['user'] instanceof User) {
            $message = Properties::unknownError($this->userLang);
            throw new IncorrectVariableFormatException($message);
        }
        $this->user = $data['user'];
    }

    private function insertUser(): bool{
        $this->errno = 0;
        $email = $this->user->getEmail();
        if(preg_match(UserSubscribe::$regex["email"],$email)){
            $insert = $this->user->insertUser();
            if($insert) return true;
            else $this->errno = Usee::FROM_USER;
        }
        else $this->errno = Usee::INCORRECT_EMAIL;
        return false;
    }
}
?>