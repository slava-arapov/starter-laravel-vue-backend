<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory(1)->create(
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@yourappname.com',
                'password' => Hash::make('super-admin-pass'),
                'email_verified_at' => null,
            ]
        );

        $user->assignRole('admin');
    }
}
