<?php

namespace Newsletter\Classes\Subscribe;

use User;

class UserSubscribe{

    private ?User $user;
    private string $userLang;

    public static array $regex = [
        'email' => '/^[a-zA-Z-_\.0-9]{4,40}@([a-z]{3,25}\.){1,6}[a-z]{2,10}$/',
        //'email' => '/^[a-zA-Z-_0-9]{4,20}@([a-z]{3,15}\.){1,6}[a-z]{2,10}$/',
    ];

    public function __construct(array $data)
    {
        
    }

    public function getUser(){return $this->user;}
    public function getUserLang(){return $this->userLang;}

    private function checkValues(array $data){
        $this->user = $data['user'];
        $this->userLang = $data['lang'];
    }
}
?>