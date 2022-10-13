<?php

namespace Newsletter\Traits;

class UserCommonTrait{

    /**
     * Unique field of users table
     */
    public static array $fields = [
        'id' => 'id',
        'email' => 'email',
        'verCode' => 'verCode',
        'unsubscCode' => 'unsubscCode',
    ];
}
?>