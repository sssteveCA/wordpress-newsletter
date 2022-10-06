<?php

namespace Newsletter\Classes\Database\Models;

use Newsletter\Classes\Database\Models;
use Newsletter\Classes\Database\Models\UsersErrors as Ue;
use Newsletter\Exceptions\IncorrectVariableFormatException;

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
        $delete_array = $this->setDeleteArray($users,$field);
        if($delete_array != null){
            $delQuery = parent::delete($delete_array["where"],$delete_array["where_format"]);
            if($this->errno == 0)return true;
        }//if($delete_array != null){
        return false;
    }

    /**
     * Set the array for wpdb delete function
     */
    private function setDeleteArray(array $users, string $field): array|null{
        $this->errno = 0;
        if(in_array($field,Users::$uniques)){
            if($field == Users::$uniques[1])
                $where_data = ["field" => "email", "format" => "%s", "method" => "getEmail"];
            else if($field == Users::$uniques[2])
                $where_data = ["field" => "verCode", "format" => "%s", "method" => "getVerCode"];
            else if($field == Users::$uniques[3])
                $where_data = ["field" => "unsubscCode", "format" => "%s", "method" => "getUnsubscCode"];
            else 
                $where_data = ["field" => "id", "format" => "%d", "method" => "getId"];
            $where_array = [ "where" => [], "where_format" => []];
            foreach($users as $user){
                if($user instanceof User){
                    $val = call_user_func(array($user, $where_data["method"]));
                    array_push($where_array["where"], [$where_data["field"] => $val]);
                    array_push($where_array["where_format"], $where_data["format"]);
                }//if($user instanceof User){
                else throw new IncorrectVariableFormatException(Ue::EXC_INVALID_USERS_ARRAY);
            }
            return $where_array;
        }//if(in_array($field,Users::$uniques)){
        else $this->errno = Ue::ERR_NOT_UNIQUE_FIELD;
        return null;
    }
}

interface UsersErrors{
    //exceptions
    const EXC_INVALID_USERS_ARRAY = "L'array degli utenti deve contenere esclusivamente oggetti utente";
    //Numbers 
    const ERR_NOT_UNIQUE_FIELD = 40;

    //Messages
    const ERR_NOT_UNIQUE_FIELD_MSG = "Il campo fornito non è univoco";
}
?>