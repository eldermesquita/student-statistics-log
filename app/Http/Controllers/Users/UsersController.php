<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserCollection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UsersController extends Controller
{
    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->with('session')
            ->allowedFilters(
                AllowedFilter::scope('full_name')
            )
            ->paginate(10)
            ->appends(request()->query());

        return Inertia::render('Users/UserManage', [
            'can' => [
                'manageUsers' => Auth::user()->can('manage-users')
            ],
            'users' => new UserCollection($users),
            'roles' => User::getRoles()
        ]);
    }
}
