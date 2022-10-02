<?php

namespace Newsletter\Classes\Database\Models;

use Newsletter\Classes\Database\Models;
use Newsletter\Classes\Database\Models\UsersErrors as Ue;

class Users extends Models implements Ue{

    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public function getError(){
        if($this->errno < Models::MAX_MODELS){
            return parent::getError();
        }
        else{
            switch($this->errno){
                default:
                    $this->error = null;
                    break;
            }
        }
        return $this->error;
    }
}

interface UsersErrors{

}
?>