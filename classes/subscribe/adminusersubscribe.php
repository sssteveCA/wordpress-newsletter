<?php

namespace Newsletter\Classes\Subscribe;

use Newsletter\Classes\Database\Models\User;
use Newsletter\Traits\ErrorTrait;
use Newsletter\Traits\SubscribeTrait;

/**
 * Class that manages user subscribe from admin panel
 */
class AdminUserSubscribe{

    use ErrorTrait, SubscribeTrait;

    private User $user;

    public function __construct(array $data)
    {
        
    }


}
?>