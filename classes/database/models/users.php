<?php

namespace Newsletter\Classes\Database\Models;

use Newsletter\Classes\Database\Models;
use Newsletter\Classes\Database\Models\UsersErrors as Ue;
use Newsletter\Exceptions\IncorrectVariableFormatException;

class Users extends Models implements Ue{

    /**
     * Unique field of users table
     */
    private static array $fields = ['id','firstName', 'lastName','email','lang','verCode','unsubscCode','subscribed','subscDate','actDate'];

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
        $query = [
            "where" => [],
            "where_format" => []
        ];
        foreach($where as $field => $val){
            if(in_array($field, Users::$fields)){
                array_push($query["where"],[$field => $val]);
                switch($field){
                    case Users::$fields[0]: //Id
                    case Users::$fields[7]: //subscribed
                        array_push($query["where_format"],"%d");
                        break;
                    case Users::$fields[1]:
                    case Users::$fields[2]:
                    case Users::$fields[3]:
                    case Users::$fields[4]:
                    case Users::$fields[5]:
                    case Users::$fields[6]:
                    case Users::$fields[8]:
                    case Users::$fields[9]:
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

    public function getUsers(array $where): array{
        $users = [];
        $this->errno = 0;
        $query = $this->setSelectQuery($where);
        if($query){

        }//if($query){
        return $users;
    }

    /**
     * Set the array for the SELECT query to get multiple users
     */
    private function setSelectQuery(array $where): array|null{
        $this->errno = 0;
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
                if(in_array($field, Users::$fields)){
                    $selectArray['query'] .= " `{$field}` =";
                    if(in_array($field, array(Users::$fields[0], Users::$fields[7]))){
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
}

interface UsersErrors{
    //exceptions
    const EXC_INVALID_FIELD = "Il campo specificato non esiste nella tabella utenti";
    //Numbers 
    const ERR_NOT_UNIQUE_FIELD = 40;

    //Messages
    const ERR_NOT_UNIQUE_FIELD_MSG = "Il campo fornito non è univoco";
}
?>