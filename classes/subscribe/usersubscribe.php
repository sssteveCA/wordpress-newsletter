<?php

namespace Newsletter\Classes\Subscribe;

use User;

class UserSubscribe{

    private ?User $user;

    public static array $regex = [
        'id' => '/^[0-9]+$/',
        'email' => '/^[a-zA-Z-_\.0-9]{4,40}@([a-z]{3,25}\.){1,6}[a-z]{2,10}$/',
        //'email' => '/^[a-zA-Z-_0-9]{4,20}@([a-z]{3,15}\.){1,6}[a-z]{2,10}$/',
        'lang' => '/^[a-z]{2,3}$/',
        'codVer' => '/^[a-z0-9]{64}$/i',
        'codDis' => '/^[a-z0-9]{64}$/i',
        'iscritto' => '/^[01]$/'
    ];

    public function __construct(array $data)
    {
        
    }

    public function getUser(){return $this->user;}
}
?>