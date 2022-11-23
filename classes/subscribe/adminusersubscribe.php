<?php

namespace Newsletter\Classes\Subscribe;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Exceptions\IncorrectVariableFormatException;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Traits\SubscribeTrait;

interface AdminUserSubscribeErrors extends ExceptionMessages{
    
}

/**
 * Class that manages user subscribe from admin panel
 */
class AdminUserSubscribe{

    use ErrorTrait, SubscribeTrait;

    private User $user;

    public function __construct(array $data)
    {
        
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

    


}
?>