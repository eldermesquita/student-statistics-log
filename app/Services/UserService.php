<?php


namespace App\Services;


use App\Http\Requests\Users\ChangeRoleRequest;
use App\Http\Requests\Users\CreateRequest;
use App\Models\User;
use DomainException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    public function createByAdmin(CreateRequest $request): array
    {
        $credentials = $this->generateCredentials();

        $user = User::create([
            'username' => $credentials['username'],
            'name' => $request['name'],
            'surname' => $request['surname'],
            'patronymic' => $request['patronymic'],
            'password' => Hash::make($credentials['password']),
            'role' => $request['role'],
        ]);

        $credentials['abbreviated_name'] = $user->abbreviated_name;

        return $credentials;
    }

    public function generateCredentials(): array
    {
        return [
            'username' => $this->generateUniqueUsername(),
            'password' => Str::random(5)
        ];
    }

    public function changeRole(ChangeRoleRequest $request, User $user): void
    {
        if ($user->roleAlreadyBeenAssigned($request['role'])) {
            throw new DomainException(__('messages.role.current_fail'));
        }
        if ($user->isRoot()) {
            throw new DomainException(__('messages.role.root_not_change'));
        }
        $user->update($request->only('role'));
    }

    private function generateUniqueUsername($length = 5): string
    {
        $username = Str::random($length);

        while (User::where('username', $username)->exists()) {
            $username = Str::random($length);
        }

        return $username;
    }
}
