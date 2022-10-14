<?php

namespace Newsletter\Classes;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\VerifyEmailErrors as Vee;
use Newsletter\Exceptions\IncorrectVariableFormatException;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Traits\ErrorTrait;

class VerifyEmail implements Vee{

    use ErrorTrait;

    private ?User $user;
    private string $verCode;

    public function __construct(array $data)
    {
        $this->assignValues($data);
    }

    public function getVerifiedUser(){return $this->user;}
    public function getVerCode(){return $this->verCode;}
    public function getError(){
        switch($this->errno){
            case Vee::FROM_USER:
                $this->error = Vee::FROM_USER_MSG;
                break;
            default:
                $this->error = null;
                break;
        }
        return $this->error;
    }

    private function assignValues(array $data): bool{
        if(!isset($data['verCode'],$data['user']))throw new NotSettedException(Vee::EXC_NOTISSET);
        if(!$data['user'] instanceof User)throw new IncorrectVariableFormatException(Vee::EXC_INVALID_TYPE);
        $this->user = $data['user'];
        return true;
    }


    public function verifyUser(): bool{
        $this->errno = 0;

        return true;
    }
}

interface VerifyEmailErrors extends ExceptionMessages{
    //Number
    const FROM_USER = 1;

    //Message
    const FROM_USER_MSG = "Errore nell'oggetto User";
}

?>