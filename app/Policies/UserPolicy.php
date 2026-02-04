<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user): Response
    {
        return $user->isSuperAdmin() ? Response::allow() : Response::deny('You do not have permission to create new admin account');
    }

    public function view(User $user): Response
    {
        return $user->isSuperAdmin() ? Response::allow() : Response::deny('You do not have permission to view all users!');
    }
}
