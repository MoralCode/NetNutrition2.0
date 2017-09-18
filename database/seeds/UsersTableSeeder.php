<?php

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
        DB::table('users')->insert([
          'net_id' => 'kjnord',
          'password' => bcrypt('kylepw'),
          'role_id' => 1
        ],[
          'net_id' => 'gofish',
          'password' => bcrypt('nickpw'),
          'role_id' => 1
        ],[
          'net_id' => 'franciss',
          'password' => bcrypt('francispw'),
          'role_id' => 1
        ],[
          'net_id' => 'sjpipho',
          'password' => bcrypt('sethpw'),
          'role_id' => 1
        ]);
    }
}
