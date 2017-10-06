<?php

use App\Role;
use App\User;
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
        User::create([
            'net_id' => 'kjnord',
            'password' => 'kylepw',
            'role_id' => Role::ADMIN,
        ]);
        User::create([
            'net_id' => 'gofish',
            'password' => 'nickpw',
            'role_id' => Role::ADMIN,
        ]);
        User::create([
            'net_id' => 'franciss',
            'password' => 'francispw',
            'role_id' => Role::ADMIN,
        ]);
        User::create([
            'net_id' => 'sjpipho',
            'password' => 'sethpw',
            'role_id' => Role::ADMIN,
        ]);

        User::create([
            'net_id' => 'chef',
            'password' => 'chefpw',
            'role_id' => Role::CHEF,
        ]);
        User::create([
            'net_id' => 'user',
            'password' => 'userpw',
            'role_id' => Role::STUDENT,
        ]);
    }
}