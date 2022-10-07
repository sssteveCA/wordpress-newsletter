<?php

namespace Newsletter\Traits;

class UserCommonTrait{

    /**
     * Unique field of users table
     */
    private static array $fields = ['id','firstName', 'lastName','email','lang','verCode','unsubscCode','subscribed','subscDate','actDate'];
}
?>