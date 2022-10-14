<?php

namespace Newsletter\Classes;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\VerifyEmailErrors as Vee;
use Newsletter\Exceptions\IncorrectVariableFormatException;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Interfaces\Constants as C;

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


    /**
     * Verify and activate the account
     */
    public function verifyUser(): bool{
        $this->errno = 0;
        $fSubscribed = User::$fields['subscribed'];
        $fVerCode = User::$fields['verCode'];
        $query = <<<SQL
WHERE `{$fVerCode}`= %s AND `{$fSubscribed}`='0';
SQL;
        $values = [$this->verCode];
        $this->user->getUser($query, $values);
        $userE = $this->user->getErrno();
        if($userE != 0){
            $this->errno = Vee::FROM_USER;
            return false;
        }
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