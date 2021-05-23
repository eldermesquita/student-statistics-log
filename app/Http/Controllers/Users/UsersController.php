<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\CreateRequest;
use App\Http\Resources\Users\UserResource;
use App\Models\User;
use App\ManageServices\UserService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class UsersController extends Controller
{
    /**
     * @var UserService
     */
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(): Response
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
            'users' => UserResource::collection($users),
            'roles' => User::getRoles(),
        ]);
    }

    public function workers(): AnonymousResourceCollection
    {
        $users = QueryBuilder::for(User::class)
            ->latest()
            ->allowedFilters(
                AllowedFilter::scope('full_name'),
            )
            ->workers()
            ->get();

        return UserResource::collection($users);
    }

    public function create(): Response
    {
        return Inertia::render('Users/Create', [
            'roles' => User::getRoles()
        ]);
    }

    public function store(CreateRequest $request): array
    {
        return $this->service->createByAdmin($request);

    }
}
