<?php

use App\DiningCenter;
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
        factory(DiningCenter::class, 10)->create();
    }
}