<?php

namespace Newsletter\Classes\Subscribe;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Exceptions\IncorrectVariableFormatException;
use Newsletter\Exceptions\NotSettedException;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Interfaces\SubscribeErrors;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Traits\SubscribeTrait;
use Newsletter\Classes\Subscribe\AdminUserSubscribeErrors as Ause;

interface AdminUserSubscribeErrors extends ExceptionMessages, SubscribeErrors{

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
            throw new NotSettedException(Ause::EXC_NOTISSET);
        }
        if(!$data['user'] instanceof User) {
            throw new IncorrectVariableFormatException(Ause::EXC_INVALID_TYPE);
        }
        $this->user = $data['user'];
    }

    


}
?>