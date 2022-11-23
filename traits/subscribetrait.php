<?php

namespace Newsletter\Traits;

use Newsletter\Classes\Database\Models\User;

/**
 * Trait with common values and mehtods used by AdminUserScribe and UserSubscribe classes
 */
trait SubscribeTrait{
    private User $user;

    public function getUser(){return $this->user;}

    public static array $regex = [
        'email' => '/^[a-zA-Z-_\.0-9]{4,40}@([a-z]{3,25}\.){1,6}[a-z]{2,10}$/',
        //'email' => '/^[a-zA-Z-_0-9]{4,20}@([a-z]{3,15}\.){1,6}[a-z]{2,10}$/',
    ];

    private function checkDuplicate(): bool{
        $user_cloned = clone $this->user;
        $sql = "WHERE `".User::$fields["email"]."` = %s";
        $values = [$this->user->getEmail()];
        return $user_cloned->getUser($sql,$values);
    }
}
?>