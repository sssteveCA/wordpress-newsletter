<?php

namespace Newsletter\Traits;

trait UserCommonTrait{

    /**
     * field of users table
     */
    public static array $fields = [
        'id' => 'id',
        'firstName' => 'firstName', 
        'lastName' => 'lastName',
        'email' => 'email',
        'lang' => 'lang',
        'verCode' => 'verCode',
        'unsubscCode' => 'unsubscCode',
        'subscribed' => 'subscribed',
        'subscDate' => 'subscDate',
        'actDate' => 'actDate'
    ];
}
?>