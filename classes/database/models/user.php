<?php

namespace Newsletter\Classes\Database\Models;

use Newsletter\Classes\Database\Model;
use Newsletter\Classes\Database\Models\UserErrors as Ue;

class User extends Model implements Ue{
    /**
     * "id" field
     */
    private int $id;
    /**
     * "firstName" field
     */
    private string $firstName;
    /**
     * "lastName" field
     */
    private string $lastName;
    /**
     * "email" field
     */
    private string $email;
    /**
     * "lang" field
     */
    private string $lang;
    /**
     * "verCode" field
     */
    private string $verCode;
    /**
     * "unsubscCode" field
     */
    private string $unsubscCode;
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
    private string $actDate;


    public function __construct(array $data)
    {
        parent::__construct($data);
    }

    public function getId(){return $this->id;}
    public function getFirstName(){return $this->firstName;}
    public function getLastName(){return $this->lastName;}
    public function getEmail(){return $this->email;}
    public function getLang(){return $this->lang;}
    public function getVerCode(){return $this->verCode;}
    public function getUnsubscCode(){return $this->unsubscCode;}
    public function getSubscDate(){return $this->subscDate;}
    public function getActDate(){return $this->addDate;}
    public function isSubscribed(){return $this->subscribed;}
}

interface UserErrors{

}
?>