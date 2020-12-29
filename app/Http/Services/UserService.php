<?php

namespace App\Http\Services;

use App\Models\User;

class UserService
{
    public function getUserWithTodoList(User $user)
    {
        return User::whereId($user->id)->with('todoList.items')->first();
    }
}
