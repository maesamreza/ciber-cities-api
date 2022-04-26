<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->role_id = 1;
        $admin->name = 'Admin';
        $admin->email = 'admin@gmail.com';
        $admin->password = Hash::make('12345678');
        $admin->save();

        $user = new User();
        $user->role_id = 2;
        $user->name = 'User';
        $user->email = 'user@gmail.com';
        $user->password = Hash::make('12345678');
        $user->save();

        $seller = new User();
        $seller->role_id = 3;
        $seller->name = 'Seller';
        $seller->email = 'seller@gmail.com';
        $seller->password = Hash::make('12345678');
        $seller->company = 'daraz';
        $seller->phone = '1234567890';
        $seller->city = 'karachi';
        $seller->state = 'karachi';
        $seller->address = 'nazimabad';
        $seller->save();
    }
}
