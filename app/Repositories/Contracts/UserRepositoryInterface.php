<?php

namespace App\Repositories\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Get the first user.
     * 
     * @return User
     */
    public function first(): User;
}
