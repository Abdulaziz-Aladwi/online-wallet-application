<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Get the first user.
     * 
     * @return User
     */
    public function first(): User
    {
        return User::first();
    }
}
