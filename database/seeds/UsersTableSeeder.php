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
          [
            'net_id' => 'kjnord',
            'password' => 'kylepw',
            'role_id' => 1
          ],
          [
            'net_id' => 'gofish',
            'password' => 'nickpw',
            'role_id' => 1
          ],
          [
            'net_id' => 'franciss',
            'password' => 'francispw',
            'role_id' => 1
          ],
          [
            'net_id' => 'sjpipho',
            'password' => 'sethpw',
            'role_id' => 1
          ],
          [
            'net_id' => 'chef',
            'password' =>'chefpw',
            'role_id' => 2
          ],
          [
            'net_id' => 'user',
            'password' => 'userpw',
            'role_id' => 3
          ]
        ]);
    }
}
