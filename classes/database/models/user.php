<?php

namespace Newsletter\Classes\Database\Models;

use Newsletter\Classes\Database\Model;
use Newsletter\Classes\Database\Models\UserErrors as Ue;

class User extends Model implements Ue{
    /**
     * "id" field
     */
    private $id;
    /**
     * "username" field
     */
    private $username;
    /**
     * "email" field
     */
    private $email;
    /**
     * "creationDate" field
     */
    private $creationDate;
    /**
     * "activtionCode" field
     */
    private $activationCode;
    /**
     * "resetCode" field
     */
    private $resetCode;
    /**
     * "verified" field
     */
    private $verified;
    /**
     * "resetted" field
     */
    private $resetted;
}

interface UserErrors{

}
?>