<?php

namespace Newsletter\Classes\Database\Models;

use Newsletter\Classes\Database\Models;
use Newsletter\Classes\Database\Models\UsersErrors as Ue;
use Newsletter\Exceptions\IncorrectVariableFormatException;
use Newsletter\Traits\UserCommonTrait;

class Users extends Models implements Ue{

    use UserCommonTrait;

    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public function getError(){
        if($this->errno < parent::MAX_MODELS){
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
    public function deleteUsers(array $where): bool{
        $this->errno = 0;
        $delete_array = $this->setDeleteArray($where);
        if($delete_array != null){
            $delQuery = parent::delete($delete_array["where"],$delete_array["where_format"]);
            if($this->errno == 0)return true;
        }//if($delete_array != null){
        return false;
    }

    /**
     * Set the array for wpdb delete function
     */
    private function setDeleteArray(array $where): array|null{
        $this->errno = 0;
        $classname = __CLASS__;
        $query = [
            "where" => [],
            "where_format" => []
        ];
        foreach($where as $field => $val){
            if(in_array($field, $classname::$fields)){
                array_push($query["where"],[$field => $val]);
                switch($field){
                    case $classname::$fields['id']: //Id
                    case $classname::$fields['subscribed']: //subscribed
                        array_push($query["where_format"],"%d");
                        break;
                    case $classname::$fields['firstName']:
                    case $classname::$fields['lastName']:
                    case $classname::$fields['email']:
                    case $classname::$fields['verCode']:
                    case $classname::$fields['unsubscCode']:
                    case $classname::$fields['subscDate']:
                    case $classname::$fields['actDate']:
                        array_push($query["where_format"],"%s");
                        break;
                    default:
                        break;
                }
            }//if(in_array($field, Users::$fields)){
            else throw new IncorrectVariableFormatException(Ue::EXC_INVALID_FIELD);
        }//foreach($where as $field => $val){
        return $query;
    }

    /**
     * Get multiple users from the users table
     * @param array $where the select filter
     * @return array|null array of User objects or null if error
     */
    public function getUsers(array $where): array|null{
        $users = [];
        $this->errno = 0;
        $query = $this->setSelectQuery($where);
        if($query){
            $result = parent::get($query["query"],$query["values"]);
            if($result){
                //foreach with array Users Object
                foreach($result as $row){
                    $user = new User($row);
                    $users[] = $user;
                }
            }
            return $users;
        }//if($query){
        return null;
    }

    /**
     * Set the array for the SELECT query to get multiple users
     */
    private function setSelectQuery(array $where): array|null{
        $this->errno = 0;
        $classname = __CLASS__;
        $selectArray = [
            "query" => "",
            "values" => []
        ];
        if(count($where) < 0){
            //Select all users
            return $selectArray;
        }//if(count($where) < 0){
        else{
            $selectArray['query'] .= "WHERE ";
            foreach($where as $field => $val){
                if(in_array($field, $classname::$fields)){
                    $selectArray['query'] .= " `{$field}` =";
                    if(in_array($field, array($classname::$fields['id'], $classname::$fields['subscribed']))){
                        $selectArray['query'] .= " %d ";
                    }
                    else{
                        $selectArray['query'] .= " %s ";
                    } 
                    array_push($selectArray["values"],$val);
                    if($field != array_key_last($where)) $selectArray['query'] .= ",";
                    else $selectArray['query'] .= ";";
                }//if(in_array($field, Users::$fields)){
                else throw new IncorrectVariableFormatException(Ue::EXC_INVALID_FIELD);
            }
            return $selectArray;
        }//else di if(count($where) < 0){
        return null;
    }

    public function insertUsers(array $users): bool{
        $this->errno = 0;
        return false;
    }

    /**
     * Set the array for the INSERT query to insert multiple users
     */
    private function setInsertArray(array $users): array|null{
        $this->errno = 0;
        if(!empty($users)){
            $insertArray = [];
            foreach($users as $user){
                if($user instanceof User){
                    
                }//if($user instanceof User){
                else throw new IncorrectVariableFormatException(Ue::EXC_INVALID_USERSARRAY);
            }
        }//if(!empty($users)){
        return null;
    }
}

interface UsersErrors{
    //exceptions
    const EXC_INVALID_FIELD = "Il campo specificato non esiste nella tabella utenti";
    const EXC_INVALID_USERSARRAY = "L' array con gli utenti non è formattato correttamente";
    //Numbers 
    const ERR_NOT_UNIQUE_FIELD = 40;

    //Messages
    const ERR_NOT_UNIQUE_FIELD_MSG = "Il campo fornito non è univoco";
}
?>