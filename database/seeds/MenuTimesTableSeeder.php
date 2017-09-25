<?php

use App\MenuTime;
use Illuminate\Database\Seeder;

class MenuTimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(MenuTime::class, 25)->create();
    }
}