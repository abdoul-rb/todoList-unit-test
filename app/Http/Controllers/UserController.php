<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function show(User $user)
    {
        return response()->json(['user' => $this->userService->getUserWithTodoList($user)]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'birthday' => 'required',
        ]);

        $user = new User();
        $user->create($request->all());

        return response()
            ->json(['user' => $this->userService->getUserWithTodoList($user)])
            ->setStatusCode(201);
    }
}
