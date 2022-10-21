<?php

namespace Newsletter\Classes\Subscribe;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Classes\Subscribe\UserUnsubscribeErrors as Uue;
use Newsletter\Exceptions\IncorrectVariableFormatException;
use Newsletter\Traits\ErrorTrait;

interface UserUnsubscribeErrors extends ExceptionMessages{

}

class UserUnsubscribe implements Uue{

    use ErrorTrait;

    private User $user;

    public function __construct(array $data)
    {
        $this->checkValues($data);
    }

    public function getUser(){return $this->user;}

    private function checkValues(array $data){
        if(!isset($data['user'])) throw new NotSettedException(Uue::EXC_NOTISSET);
        if(!$data['user'] instanceof User) throw new IncorrectVariableFormatException(Uue::EXC_INVALID_TYPE);
        $this->user = $data['user'];
    }
}
?>