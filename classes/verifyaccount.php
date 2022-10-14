<?php

namespace Newsletter\Classes;

use Newsletter\Classes\Database\Models\User;

class VerifyEmail{

    private ?User $user;

    public function __construct(array $data)
    {
        
    }

    public function getVerifiedUser(){return $this->user;}
}

?>