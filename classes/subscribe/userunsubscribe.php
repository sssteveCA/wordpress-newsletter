<?php

namespace Newsletter\Classes\Subscribe;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Traits\ErrorTrait;

interface UserUnsubscribeErrors extends ExceptionMessages{

}

class UserUnsubscribe{
    use ErrorTrait;

    private User $user;
    private string $userLang;

    public function __construct(array $data)
    {
        
    }

    public function getUser(){return $this->user;}
    public function getUserLang(){return $this->userLang;}
}
?>