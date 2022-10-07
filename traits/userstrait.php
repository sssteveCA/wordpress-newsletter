<?php

namespace Newsletter\Traits;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Exceptions\IncorrectVariableFormatException;
use Newsletter\Classes\Database\Models\UsersErrors as Ue;

/**
 * Secondary methods used by Users class
 */
trait UsersTrait{

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
     * Set the array for the INSERT query to insert multiple users
     * @param array $users the array of User objects
     * @param bool $withNames if true the query insert also 'firstName' & 'lastName' fields
     * @return array the array ready for sanitize
     */
    private function setInsertArray(array $users, bool $withNames): array|null{
        $this->errno = 0;
        if(!empty($users)){
            $insertArray = [
                "query" => "",
                "values" => []
            ];
            $insertArray["query"] .= $this->setFirstPartInsertSql($withNames);
            $currentTime = date("Y-m-d H:i:s");
            foreach($users as $k => $user){
                if($user instanceof User){
                    if($this->validateUserData($user,$withNames)){
                        $insertSingleArray = $this->setSingleInsertValues($user, $withNames, $currentTime);
                        $insertArray["query"] .= $insertSingleArray["query"];
                        array_push($insertArray["values"], $insertSingleArray["values"]);
                    }//if($this->validateUserData($user,$withNames)){
                    else throw new IncorrectVariableFormatException(Ue::EXC_DATA_MISSED);
                    if($k != array_key_last($users)) $insertArray["query"] .= ",";
                    else $insertArray["query"] .= ";";
                }//if($user instanceof User){
                else throw new IncorrectVariableFormatException(Ue::EXC_INVALID_USERSARRAY);
            }//foreach($users as $k => $user){
            return $insertArray;
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
INSERT INTO `{$this->fullTableName}` (`{$classname::$fields['firstName']}`,`{$classname::$fields['lastName']}`,`{$classname::$fields['email']}`,`{$classname::$fields['lang']}`,`{$classname::$fields['verCode']}`,`{$classname::$fields['subscribed']}`,`{$classname::$fields['subscDate']}`) VALUES
SQL;
        }
        else{
            $first_part = <<<SQL
INSERT INTO `{$this->fullTableName}` (`{$classname::$fields['email']}`,`{$classname::$fields['lang']}`,`{$classname::$fields['verCode']}`,`{$classname::$fields['subscribed']}`,`{$classname::$fields['subscDate']}`) VALUES
SQL;
        }
        return $first_part;
    }

    /**
     * Add to INSERT query, data of single user
     * @param User $user
     * @param bool $withNames
     * @param string $currentTime
     * @return array
     */
    private function setSingleInsertValues(User $user, bool $withNames, string $currentTime): array{
        $insertSingleArray = [
            "query" => "", "values" => []
        ];
        if($withNames){
            $insertSingleArray["query"] = "(%s,%s,%s,%s,0,{$currentTime})";
            $userValues = [
                $user->getFirstName(), $user->getLastName(),$user->getEmail(),$user->getLang()
            ];
            array_push($insertSingleArray["values"],$userValues);
        }//if($withNames){
        else{
            $insertSingleArray["query"] = "(%s,%s,0,{$currentTime})";
            $userValues = [ $user->getEmail(),$user->getLang() ];
            array_push($insertSingleArray["values"],$userValues);
        }//else di if($withNames){
        return $insertSingleArray;
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
?>