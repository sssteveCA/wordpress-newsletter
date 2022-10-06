<?php

namespace Newsletter\Classes\Database\Models;

use Newsletter\Classes\Database\Models;
use Newsletter\Classes\Database\Models\UsersErrors as Ue;

class Users extends Models implements Ue{

    /**
     * Unique field of users table
     */
    private static array $uniques = ['id','email','verCode','unsubscCode'];

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
                case Ue::ERR_NOT_UNIQUE_FIELD:
                    $this->error = Ue::ERR_NOT_UNIQUE_FIELD_MSG;
                    break;
                default:
                    $this->error = null;
                    break;
            }
        }
        return $this->error;
    }

    /**
     * delete multiple users in database
     * @param array $users user objects to delete in the database
     * @param string the field used to select the users to delete
     */
    public function deleteUsers(array $users, string $field): bool{
        $this->errno = 0;
        return false;
    }

    private function setDeleteQuery(array $users, string $field): string|null{
        if(in_array($field,Users::$uniques)){
            if($field == Users::$uniques[1])
                $where_data = [
                    "field" => "email", "method" => "getEmail"];
            else if($field == Users::$uniques[2])
                $where_data = ["field" => "verCode", "method" => "getVerCode"];
            else if($field == Users::$uniques[3])$where_data = ["field" => "unsubscCode", "method" => "getUnsubscCode"];
            else $where_data = ["field" => "id", "method" => "getId"];
        }//if(in_array($field,Users::$uniques)){
        else $this->errno = Ue::ERR_NOT_UNIQUE_FIELD;
        return null;
    }
}

interface UsersErrors{
    //Numbers 
    const ERR_NOT_UNIQUE_FIELD = 40;

    //Messages
    const ERR_NOT_UNIQUE_FIELD_MSG = "Il campo fornito non è univoco";
}
?>