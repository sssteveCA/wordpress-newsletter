<?php

namespace Newsletter\Classes\Subscribe;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Traits\ErrorTrait;


/**
 * Class that manages user subscribe from admin panel
 */
class AdminUserSubscribe{

    use ErrorTrait;

    private User $user;

    public function __construct(array $data)
    {
        
    }


}
?>