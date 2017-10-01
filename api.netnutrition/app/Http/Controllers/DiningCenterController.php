<?php

namespace App\Http\Controllers;

use App\DiningCenter;
use App\Food;
use App\Menu;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use function array_key_exists;
use function var_dump;

class DiningCenterController extends ApiController
{
    public function loadJson()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', '1000000000');

        return json_decode(File::get('../app/Console/PythonWebScraper/data.json'), true, 2048);
    }

    public function foreachDiningCenter($diningCenters)
    {
        foreach ($diningCenters as $diningCenterName => $diningCenterInformation) {
            $diningCenter = DiningCenter::whereName($diningCenterName)
                ->firstOrCreate([
                    'name' => $diningCenterName,
                    'latitude' => 0,
                    'longitude' => 0,
                ]);

            if (array_key_exists('dates', $diningCenterInformation)) {
                $this->foreachDates($diningCenterInformation['dates'], $diningCenter);
            } elseif (array_key_exists('stations', $diningCenterInformation)) {
                $this->foreachStations($diningCenterInformation['stations'], $diningCenter);
            } else {
                abort(500, 'sjpipho@iastate managed to **** this up again');
            }
        }
    }

    public function foreachStations($stations, $diningCenter)
    {
        foreach ($stations as $stationName => $stationInformation) {
//            $station = Station::whereName($stationName)
//                ->firstOrCreate([
//                    'name' => $stationName,
//                    'dining_center_id' => $diningCenter->id,
//                ]);
            $station = null;

            $this->foreachDates($stationInformation['dates'], $diningCenter, $station);
        }
    }

    public function foreachDates($dates, $diningCenter, $station = null)
    {
        var_dump($diningCenter->name);
    }

    public function index()
    {
        $webScraperData = $this->loadJson();

        $this->foreachDiningCenter($webScraperData);

        die();

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

    /**
     * @param $id
     *
     * @return DiningCenter|\Illuminate\Database\Eloquent\Builder|Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show($id)
    {
        return DiningCenter::findOrFail($id);
    }

    /**
     * @param $id
     *
     * @return \App\Menu[]|Collection|mixed
     */
    public function showMenus($id)
    {
        return DiningCenter::findOrFail($id)->menus;
    }

    /**
     * @param $id
     *
     * @return Collection
     */
    public function showFoods($id)
    {
        $foodCollection = new Collection();
        foreach (DiningCenter::findOrFail($id)->menus as $menu) {
            foreach ($menu->food_items as $food) {
                if (!$foodCollection->contains($food)) {
                    $foodCollection->add($food);
                }
            }
        }

        return $foodCollection;
    }
}