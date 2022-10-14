<?php

namespace Newsletter\Classes;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Classes\VerifyEmailErrors as Vee;

class VerifyEmail implements Vee{

    private ?User $user;

    public function __construct(array $data)
    {
        
    }

    public function getVerifiedUser(){return $this->user;}
}

interface VerifyEmailErrors{

}

?>