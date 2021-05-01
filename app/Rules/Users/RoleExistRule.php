<?php

namespace App\Rules\Users;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class RoleExistRule implements Rule
{
    /**
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return array_key_exists($value, User::getRoles(true));
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return __('validation.role_not_exist');
    }
}
