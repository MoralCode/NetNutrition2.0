<?php

use Illuminate\Database\Seeder;

class DiningCentersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dining_centers')->insert([
          ['name' => 'Union Drive Marketplace'],
          ['name' => 'Seasons'],
          ['name' => 'Conversations'],
          ['name' => 'Windows'],
          ['name' => 'Storms'],
          ['name' => 'Memorial Union'],
          ['name' => "Clyde's fresh express"]
        ]);
    }
}
