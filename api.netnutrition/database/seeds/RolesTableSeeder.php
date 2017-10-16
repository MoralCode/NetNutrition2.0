<?php

use App\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'id' => Role::ADMIN,
            'name' => 'Admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Role::create([
            'id' => Role::CHEF,
            'name' => 'Chef',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        Role::create([
            'id' => Role::STUDENT,
            'name' => 'Student',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}