<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return User::factory([
            'name' => 'root',
            'username' => 'root',
            'surname' => 'root',
            'patronymic' => 'root',
            'password' => Hash::make(config('app.root_admin_password')),
        ])->root()->create();
    }
}
