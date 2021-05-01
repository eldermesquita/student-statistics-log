<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ChangeRoleRequest;
use App\Models\User;
use App\Services\UserService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ChangeRoleController extends Controller
{
    /**
     * @var UserService
     */
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function __invoke(ChangeRoleRequest $request, User $user): RedirectResponse
    {
        try {
            $this->service->changeRole($request, $user);
        } catch (DomainException $exception) {
            return Redirect::back()->with('error', $exception->getMessage());
        }

        return Redirect::back()->with('success', __('messages.role.change_success'));
    }
}
