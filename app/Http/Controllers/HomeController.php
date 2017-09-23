<?php

namespace App\Http\Controllers;

use App\DiningCenter;
use App\Food;
use App\Menu;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    public function dashboard()
    {
        $webScraperData = json_decode(File::get('../app/Console/PythonWebScraper/data.json'), true, 2048);

        // Foreach of the dining centers
        foreach ($webScraperData as $diningCenter => $menus) {
            $diningCenter = DiningCenter::whereName($diningCenter)->firstOrCreate([
                'name' => $diningCenter,
                'latitude' => 0,
                'longitude' => 0,
            ]);

            // Foreach menus at a dining center
            foreach ($menus['dates'] as $menuDate => $dailyMenus) {
                // Foreach of the daily menus with a given date
                foreach ($dailyMenus['meals'] as $menuName => $foodItems) {
                    $databaseFoods = new Collection([]);
                    foreach ($foodItems['foods'] as $food) {

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

                        // Add the object to our food collection for menu use
                        $databaseFoods->add($foodObj);
                    }

                        dump("Iteration");
                    Menu::create([
                        'name' => $menuName,
                        'start' => Carbon::createFromDate(),
                        'end' => Carbon::createFromDate(),
                        'dining_center_id' => $diningCenter->id,
                        'food_items' => $databaseFoods,
                    ]);
                }dd("Done");
            }
        }

        dd();
    }
}