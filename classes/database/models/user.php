<?php

namespace Newsletter\Classes\Database\Models;

use Newsletter\Classes\Database\Model;
use Newsletter\Classes\Database\ModelErrors;
use Newsletter\Classes\Database\Models\UserErrors as Ue;
use Newsletter\Interfaces\ExceptionMessages;
use Newsletter\Traits\UserCommonTrait;
use Newsletter\Traits\UserTrait;

interface UserErrors extends ExceptionMessages{
    //Numbers
    const ERR_MISSING_DATA = 40;

    //Messages
    const ERR_MISSING_DATA_MSG = "Uno o più dati richiesti non sono stati settati";
}

class User extends Model implements Ue{

    use UserCommonTrait, UserTrait;

    /**
     * "id" field
     */
    private ?int $id;
    /**
     * "firstName" field
     */
    private ?string $firstName;
    /**
     * "lastName" field
     */
    private ?string $lastName;
    /**
     * "email" field
     */
    private ?string $email;
    /**
     * "lang" field
     */
    private ?string $lang;
    /**
     * "verCode" field
     */
    private ?string $verCode;
    /**
     * "unsubscCode" field
     */
    private ?string $unsubscCode;
    /**
     * "subscribed" field
     */
    private string $subscribed;
    /**
     * "subscDate" field
     */
    private ?string $subscDate;
    /**
     * "actDate" field
     */
    private ?string $actDate;

    /**
     * Methods used by User class to create the array for user record creation
     */
    public static $insertArrayFunctions = ['backend' => 'insertUserArrayAdmin', 'frontend' => 'insertUserArray'];


    public function __construct(array $data)
    {
        //file_put_contents("log.txt","User constructor data => ".var_export($data,true)."\r\n",FILE_APPEND);
        parent::__construct($data);
        $this->assignValues($data);
    }

    public function getId(){return $this->id;}
    public function getFirstName(){return $this->firstName;}
    public function getLastName(){return $this->lastName;}
    public function getEmail(){return $this->email;}
    public function getLang(){return $this->lang;}
    public function getVerCode(){return $this->verCode;}
    public function getUnsubscCode(){return $this->unsubscCode;}
    public function getSubscDate(){return $this->subscDate;}
    public function getActDate(){return $this->actDate;}
    public function isSubscribed(){
        if($this->subscribed == '1') return true;
        else return false;
    }

    public function getError(){
        if($this->errno < static::MAX_MODEL){
            return parent::getError();
        }
        switch($this->errno){
            case Ue::ERR_MISSING_DATA:
                $this->error = Ue::ERR_MISSING_DATA_MSG;
                break;
            default:
                $this->error = null;
                break;
        }
        return $this->error;
    }

    private function assignValues(array $data){
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->firstName = isset($data['firstName']) ? $data['firstName'] : null;
        $this->lastName = isset($data['lastName']) ? $data['lastName'] : null;
        $this->email = isset($data['email']) ? $data['email'] : null;
        $this->lang = isset($data['lang']) ? $data['lang'] : null;
        $this->verCode = isset($data['verCode']) ? $data['verCode'] : null;
        $this->unsubscCode = isset($data['unsubscCode']) ? $data['unsubscCode'] : null;
        $this->subscribed = isset($data['subscribed']) ? $data['subscribed'] : '0';
        $this->subscDate = isset($data['subscDate']) ? $data['subscDate'] : null;
        $this->actDate = isset($data['actDate']) ? $data['actDate'] : null;
    }

    /**
     * Delete an User from the table
     */
    public function deleteUser(string $query, array $values){
        $delete = parent::delete($query,$values);
        return $delete;
    }

    /**
     * Get an User from the table
     */
    public function getUser(string $query, array $values){
        $user = parent::get($query,$values);
        if($user){
            /* echo "User getUser result => \r\n";
            var_dump($user); */
            $this->id = $user[User::$fields["id"]];
            $this->firstName = $user[User::$fields["firstName"]];
            $this->lastName = $user[User::$fields["lastName"]];
            $this->email = $user[User::$fields["email"]];
            $this->lang = $user[User::$fields["lang"]];
            $this->verCode = $user[User::$fields["verCode"]];
            $this->unsubscCode = $user[User::$fields["unsubscCode"]];
            $this->subscribed = $user[User::$fields["subscribed"]];
            $this->subscDate = $user[User::$fields["subscDate"]];
            $this->actDate = $user[User::$fields["actDate"]];
            return true;
        }//if($user){
        return false;
    }

    /**
     * Insert a new User in the table
     * @param string $callback the function used to create the array for user record creation
     */
    public function insertUser(string $callback){
        $this->errno = 0;
        $insert_array = call_user_func(array($this, $callback));
        //file_put_contents("log.txt", "User insertUser\r\n".var_export($insert_array,true)."\r\n",FILE_APPEND);
        if($insert_array != null){
            $insert = parent::insert($insert_array["values"],$insert_array["format"]);
            return $insert;
        }//if(isset($this->email, $this->verCode, $this->subscDate)){
        return false;
    }

    /**
     * Update an existing User in the table
     */
    public function updateUser(array $set, array $where = []){
        $update = parent::update($set,$where);
        return $update;
    }
}


?>