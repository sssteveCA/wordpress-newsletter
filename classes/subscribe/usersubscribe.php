<?php

namespace Newsletter\Classes\Subscribe;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\Properties;
use Newsletter\Exceptions\IncorrectVariableFormatException;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Classes\Subscribe\UserSubscribeError as Usee;
use Newsletter\Interfaces\SubscribeErrors;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Traits\SubscribeTrait;

interface UserSubscribeError extends ExceptionMessages, SubscribeErrors{
   
}

class UserSubscribe implements Usee{

    use ErrorTrait, SubscribeTrait;

    public function __construct(array $data)
    {
        $this->checkValues($data);
        $this->insertUser();
    }

    public function getError(){
        switch($this->errno){
            case Usee::FROM_USER:
                $this->error = Usee::FROM_USER_MSG;
                break;
            case Usee::INCORRECT_EMAIL:
                $this->error = Usee::INCORRECT_EMAIL_MSG;
                break;
            case Usee::EMAIL_EXISTS:
                $this->error = Usee::EMAIL_EXISTS_MSG;
                break;
            default:
                $this->error = null;
                break;
        }
    }

    private function checkValues(array $data){
        if(!isset($data['user'])){
            throw new NotSettedException(Usee::EXC_NOTISSET);
        }
        if(!$data['user'] instanceof User) {
            throw new IncorrectVariableFormatException(Usee::EXC_INVALID_TYPE);
        }
        $this->user = $data['user'];
    }

    private function insertUser(): bool{
        $email = $this->user->getEmail();
        if(preg_match(UserSubscribe::$regex["email"],$email)){
            if($this->checkDuplicate()){
                $this->errno = Usee::EMAIL_EXISTS;
                return false;
            }
            $insert = $this->user->insertUser();
            if($insert) return true;
            else $this->errno = Usee::FROM_USER;
        }
        else $this->errno = Usee::INCORRECT_EMAIL;
        return false;
    }
}
?>