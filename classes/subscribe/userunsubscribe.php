<?php

namespace Newsletter\Classes\Subscribe;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Classes\Subscribe\UserUnsubscribeErrors as Uue;
use Newsletter\Exceptions\IncorrectVariableFormatException;
use Newsletter\Traits\ErrorTrait;

interface UserUnsubscribeErrors extends ExceptionMessages{
    const CODE_NOT_FOUND = 1;
    const FROM_USER = 2;

    const CODE_NOT_FOUND_MSG = "Il codice di disiscrizione inserito non è stato trovato";
    const FROM_USER_MSG = "Errore dall'oggetto User";
}

class UserUnsubscribe implements Uue{

    use ErrorTrait;

    private User $user;

    public function __construct(array $data)
    {
        $this->checkValues($data);
        $this->deleteUser();
    }

    public function getUser(){return $this->user;}
    public function getError(){
        switch($this->errno){
            case Uue::CODE_NOT_FOUND:
                $this->error = Uue::CODE_NOT_FOUND_MSG;
                break;
            case Uue::FROM_USER:
                $this->error = Uue::FROM_USER_MSG;
                break;
            default:
                $this->error = null;
                break;
        }
        return $this->error;
    }

    private function checkValues(array $data){
        if(!isset($data['user'])) throw new NotSettedException(Uue::EXC_NOTISSET);
        if(!$data['user'] instanceof User) throw new IncorrectVariableFormatException(Uue::EXC_INVALID_TYPE);
        $this->user = $data['user'];
    }

    private function checkUnsubscribeCode(): bool{
        $user_cloned = clone $this->user;
        $sql = "WHERE `".User::$fields["unsubscCode"]."` = %s";
        $values = [$this->user->getUnsubscCode()];
        $found = $user_cloned->getUser($sql,$values);
        if($found) $this->user = $user_cloned;
        return $found;
    }

    private function deleteUser(): bool{
        if(!$this->checkUnsubscribeCode()){
            $this->errno = Uue::CODE_NOT_FOUND;
            return false;
        }
        $sql = "WHERE `".User::$fields["unsubscCode"]."` = %s";
        $values = [$this->user->getUnsubscCode()];
        $this->user->deleteUser($sql,$values);
        if($this->user->getErrno() != 0){
            $this->errno = Uue::FROM_USER;
            return false;
        }
        return true;
    }
}
?>