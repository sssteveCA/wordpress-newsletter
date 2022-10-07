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

    /**
     * Insert multiple users in database
     * @param array $users the array of User objects
     * @param bool $withNames if true the query insert also 'firstName' & 'lastName' fields
     * @return bool true if the users have been inserted, false otherwise
     */
    public function insertUsers(array $users, bool $withNames): bool{
        $this->errno = 0;
        return false;
    }

    /**
     * Set the array for the INSERT query to insert multiple users
     * @param array $users the array of User objects
     * @param bool $withNames if true the query insert also 'firstName' & 'lastName' fields
     * @return array the array ready for sanitize
     */
    private function setInsertArray(array $users, bool $withNames): array|null{
        $this->errno = 0;
        $classname = __CLASS__;
        if(!empty($users)){
            $insertArray = [
                "query" => "",
                "values" => []
            ];
            $insertArray["query"] .= $this->setFirstPartInsertSql($withNames);
            foreach($users as $user){
                if($user instanceof User){
                    if($this->validateUserData($user,$withNames)){
                        if($withNames){
                            $insertArray["query"] .= "(%s,%s,%s,%s,0,{})";
                            $userValues = [];
                            array_push($values);
                        }
                        
                    }//if($this->validateUserData($user,$withNames)){
                    else throw new IncorrectVariableFormatException(Ue::EXC_DATA_MISSED);
                }//if($user instanceof User){
                else throw new IncorrectVariableFormatException(Ue::EXC_INVALID_USERSARRAY);
            }
        }//if(!empty($users)){
        return null;
    }

    /**
     * Set the first part of INSERT query for users
     * @param bool $withNames if true the query insert also 'firstName' & 'lastName' fields
     * @return string the first part of the INSERT query
     */
    private function setFirstPartInsertSql(bool $withNames): string{
        $classname = __CLASS__;
        if($withNames){
            $first_part = <<<SQL
INSERT INTO `{$this->fullTableName}` (`{$classname::$fields['firstName']}`,`{$classname::$fields['lastName']}`,`{$classname::$fields['email']}`,`{$classname::$fields['verCode']}`,`{$classname::$fields['subscribed']}`,`{$classname::$fields['subscDate']}`) VALUES
SQL;
        }
        else{
            $first_part = <<<SQL
INSERT INTO `{$this->fullTableName}` (`{$classname::$fields['email']}`,`{$classname::$fields['verCode']}`,`{$classname::$fields['subscribed']}`,`{$classname::$fields['subscDate']}`) VALUES
SQL;
        }
        return $first_part;
    }

    /**
     * Check if User object contains all the required data for insert
     */
    private function validateUserData(User $user, bool $withNames): bool{
        if($user->getEmail() == null) return false;
        if($user->getLang() == null) return false;
        if($user->getVerCode() == null) return false;
        if(!$withNames) return true;
        if($user->getFirstName() == null) return false;
        if($user->getLastName() == null) return false;
        return true;
    }
}

interface UsersErrors{
    //exceptions
    const EXC_INVALID_FIELD = "Il campo specificato non esiste nella tabella utenti";
    const EXC_INVALID_USERSARRAY = "L' array con gli utenti non è formattato correttamente";
    const EXC_DATA_MISSED = "Uno o più dati richiesti sono mancanti";
    //Numbers 
    const ERR_NOT_UNIQUE_FIELD = 40;

    //Messages
    const ERR_NOT_UNIQUE_FIELD_MSG = "Il campo fornito non è univoco";
}
?>