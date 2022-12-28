<?php

namespace Newsletter\Classes\Api;

use Newsletter\Traits\ErrorTrait;

class AuthCheck{
    use ErrorTrait;

    private string $username;
    private string $password;

    public function __construct(array $data)
    {
        
    }

    public function getError(){
        switch($this->errno){
            default:
                $this->error = null;
        }
        return $this->error;
    }
}
?>