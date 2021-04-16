<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Resources\Users\UserCollection;
use App\Http\Resources\Users\WorkersCollection;
use App\Models\User;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UsersController extends Controller
{
    public function index()
    {
        $users = QueryBuilder::for(User::class)
            ->with('session')
            ->latest()
            ->allowedFilters(
                AllowedFilter::scope('full_name')
            )
            ->paginate(10)
            ->appends(request()->query());

        return Inertia::render('Users/UserManage', [
            'filters' => Request::all('filter.full_name'),
            'can' => [
                'manageUsers' => Auth::user()->can('manage-users')
            ],
            'users' => new UserCollection($users),
            'roles' => User::getRoles()
        ]);
    }
    public function workers()
    {
        $users = QueryBuilder::for(User::class)
            ->latest()
            ->allowedFilters(
                AllowedFilter::scope('full_name'),
            )
            ->workers()
            ->get();

        return new WorkersCollection($users);
    }
}
