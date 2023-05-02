<?php

namespace Newsletter\Classes\Database\Models;

use Newsletter\Classes\Database\ModelErrors;
use Newsletter\Classes\Database\Models;
use Newsletter\Classes\Database\Models\UsersErrors as Ue;
use Newsletter\Exceptions\IncorrectVariableFormatException;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Traits\UserCommonTrait;
use Newsletter\Traits\UsersTrait;

interface UsersErrors extends ExceptionMessages{
    //Numbers 
    const ERR_NOT_UNIQUE_FIELD = 40;
    const ERR_VOID_INSERT_ARRAY = 41;

    //Messages
    const ERR_NOT_UNIQUE_FIELD_MSG = "Il campo fornito non è univoco";
    const ERR_VOID_INSERT_ARRAY_MSG = "L'array con gli utenti da inserire è vuoto";
    
}

class Users extends Models implements Ue{

    use UserCommonTrait, UsersTrait;

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
                case Ue::ERR_VOID_INSERT_ARRAY:
                    $this->error = Ue::ERR_VOID_INSERT_ARRAY_MSG;
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
            parent::delete($delete_array["where"],$delete_array["where_format"]);
            if($this->errno == 0)return true;
        }//if($delete_array != null){
        return false;
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
                    $row['tableName'] = $this->getTableName();
                    $user = new User($row);
                    $users[] = $user;
                }
            }
            return $users;
        }//if($query){
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
        $insertArray = $this->setInsertArray($users,$withNames);
        $insert = parent::insert($insertArray["query"],$insertArray["values"]);
        if($insert)return true;
        return false;
    }

    /**
     * Update multiple users in database
     * @param array $data the array with the new data 
     * @param array $where the where condition
     * @param array $format (optional) specify the format of the $data array
     * @param array $where_f (optional) specify the format of the $where_f array
     * @return bool true if update query successfully
     */
    public function updateUsers(array $data, array $where, array $format = [], array $where_f = []): bool{
        $this->errno = 0;
        $update = parent::update($data,$where,$format,$where_f);
        if($this->errno != 0)return false;
        return true;
    }
}


?>