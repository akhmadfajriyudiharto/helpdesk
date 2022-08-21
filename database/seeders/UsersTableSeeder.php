<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (User::count() === 0) {
            // Add default User
            $user = new User();
            $user->name = 'Admin';
            $user->email = 'admin@admin.com';
            $user->password = bcrypt('12345678');
            $user->role_id = 1;
            $user->save();
        }
    }
}
