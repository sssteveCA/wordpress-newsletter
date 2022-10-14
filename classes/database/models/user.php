<?php

namespace Newsletter\Classes\Database\Models;

use Newsletter\Classes\Database\Model;
use Newsletter\Classes\Database\Models\UserErrors as Ue;
use Newsletter\Traits\UserCommonTrait;
use Newsletter\Traits\UserTrait;

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
    private bool $subscribed;
    /**
     * "subscDate" field
     */
    private ?string $subscDate;
    /**
     * "actDate" field
     */
    private ?string $actDate;


    public function __construct(array $data)
    {
        //var_dump($data);
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
    public function isSubscribed(){return $this->subscribed;}

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
        $this->subscribed = isset($data['subscribed']) ? $data['subscribed'] : false;
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
        $getOk = false;
        $user = parent::get($query,$values);
        if($user){
            $this->id = $user["id"];
            $this->firstName = $user["firstName"];
            $this->lastName = $user["lastName"];
            $this->email = $user["email"];
            $this->lang = $user["lang"];
            $this->verCode = $user["verCode"];
            $this->unsubscCode = $user["unsubscCode"];
            $this->subscribed = $user["subscribed"];
            $this->subscDate = $user["subscDate"];
            $this->actDate = $user["actDate"];
        }//if($user){
        return $getOk;
    }

    /**
     * Insert a new User in the table
     */
    public function insertUser(){
        $this->errno = 0;
        $insert_array = $this->insertUserArray();
        echo "User insertUser\r\n";
        //var_dump($insert_array);
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

interface UserErrors{
    //Numbers
    const ERR_MISSING_DATA = 40;

    //Messages
    const ERR_MISSING_DATA_MSG = "Uno o più dati richiesti non sono stati settati";
}
?>