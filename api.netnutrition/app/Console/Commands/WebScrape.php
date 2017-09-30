<?php

namespace App\Console\Commands;

use App\DiningCenter;
use App\Food;
use App\Menu;
use File;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class WebScrape extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:netnutrition';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape the net nutrition web site';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', '1000000000');

        $webScraperData = json_decode(File::get('app/Console/PythonWebScraper/data.json'), true, 2048);

        // Foreach of the dining centers
        foreach ($webScraperData as $diningCenter => $menus) {
            $diningCenter = DiningCenter::whereName($diningCenter)
                ->firstOrCreate([
                    'name' => $diningCenter,
                    'latitude' => 0,
                    'longitude' => 0,
                ]);

            if (!array_key_exists('dates', $menus)) {
                foreach ($menus['stations'] as $foodArea) {
                    // Foreach menus at a dining center
                    foreach ($foodArea['dates'] as $menuDate => $dailyMenus) {

                        // Foreach of the daily menus with a given date
                        foreach ($dailyMenus['meals'] as $menuName => $foodItems) {
                            $databaseFoods = new Collection([]);

                            // Foreach of the foods within a menu
                            foreach ($foodItems['foods'] as $food) {

                                if (array_key_exists('name', $food)) {
                                    // If the food object exists in the db
                                    if (is_null($foodObj = Food::whereName($food['name'])
                                        ->first())) {
                                        // Create one if not found
                                        $foodObj = Food::create([
                                            'name' => $food['name'],
                                        ]);
                                    } else {
                                        // Else update the existing one to the new food name
                                        $foodObj->update([
                                            'name' => $food['name'],
                                        ]);
                                    }
                                    $databaseFoods->add($foodObj);
                                }
                            }

                            // Add the object to our food collection for menu use                             }

                            Menu::create([
                                'name' => $menuName,
                                'start' => Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($menuDate)))
                                    ->hour(0)
                                    ->minute(0)
                                    ->second(0),
                                'end' => Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($menuDate)))
                                    ->hour(23)
                                    ->minute(59)
                                    ->second(59),
                                'dining_center_id' => $diningCenter->id,
                                'food_items' => $databaseFoods,
                            ]);
                        }
                    }
                }
            } else {
                // Foreach menus at a dining center
                foreach ($menus['dates'] as $menuDate => $dailyMenus) {

                    // Foreach of the daily menus with a given date
                    foreach ($dailyMenus['meals'] as $menuName => $foodItems) {
                        $databaseFoods = new Collection([]);

                        // Foreach of the foods within a menu
                        foreach ($foodItems['foods'] as $food) {
                            if (array_key_exists('name', $food)) {
                                // If the food object exists in the db
                                if (is_null($foodObj = Food::whereName($food['name'])
                                    ->first())) {
                                    // Create one if not found
                                    $foodObj = Food::create([
                                        'name' => $food['name'],
                                    ]);
                                } else {
                                    // Else update the existing one to the new food name
                                    $foodObj->update([
                                        'name' => $food['name'],
                                    ]);
                                    $databaseFoods->add($foodObj);

                                }

                            }
                        }
                        // Add the object to our food collection for menu use}

                        Menu::create([
                            'name' => $menuName,
                            'start' => Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($menuDate)))
                                ->hour(0)
                                ->minute(0)
                                ->second(0),
                            'end' => Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($menuDate)))
                                ->hour(23)
                                ->minute(59)
                                ->second(59),
                            'dining_center_id' => $diningCenter->id,
                            'food_items' => $databaseFoods,
                        ]);
                    }
                }
            }
        }
    }
}