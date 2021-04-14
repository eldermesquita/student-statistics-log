<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ChangeRoleRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ChangeRoleController extends Controller
{
    public function __invoke(ChangeRoleRequest $request, User $user)
    {
        if (!array_key_exists($request['role'], User::getRoles())) {
            return Redirect::back()->with('error', __('messages.role.not_exist'));
        }

        if ($user->role === $request['role']) {
            return Redirect::back()->with('error', __('messages.role.current_fail'));
        }

        $user->update($request->only('role'));

        return Redirect::back()->with('success', __('messages.role.change_success'));
    }
}
