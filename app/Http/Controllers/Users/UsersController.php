<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::with('session')->paginate(10);
        $roles = User::getRoles();

        return Inertia::render('Users/UserManage', [
            'users' => new UserCollection($users),
            'roles' => $roles
        ]);
    }
}
