<?php

namespace Newsletter\Classes\Database\Models;

use Newsletter\Classes\Database\Model;
use Newsletter\Classes\Database\Models\UserErrors as Ue;

class User extends Model implements Ue{
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
    private string $subscDate;
    /**
     * "actDate" field
     */
    private ?string $actDate;


    public function __construct(array $data)
    {
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

    private function assignValues(array $data){
        $this->id = isset($data['id']) ? $data['id'] : null;
        $this->firstName = isset($data['firstName']) ? $data['firstName'] : null;
        $this->lastName = isset($data['lastName']) ? $data['lastName'] : null;
        $this->email = isset($data['email']) ? $data['email'] : null;
        $this->verCode = isset($data['verCode']) ? $data['verCode'] : null;
        $this->unsubscCode = isset($data['unsubscCode']) ? $data['unsubscCode'] : null;
        $this->subscribed = isset($data['subscribed']) ? $data['subscribed'] : false;
        $this->subscDate = isset($data['subscDate']) ? $data['subscDate'] : null;
        $this->actDate = isset($data['actDate']) ? $data['actDate'] : null;
    }

    /**
     * Delete an User from the database
     */
    public function deleteUser(string $query, array $values){
        $delete = parent::delete($query,$values);
        return $delete;
    }
}

interface UserErrors{

}
?>