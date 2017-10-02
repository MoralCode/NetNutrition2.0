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
     * Execute the command
     *
     * @return int
     */
    public function handle()
    {
        $webScraperData = $this->loadJson();

        $this->foreachDiningCenter($webScraperData);

        return 0;
    }

    public function loadJson()
    {
        ini_set('memory_limit', '2048M');
        ini_set('max_execution_time', '1000000000');

        return json_decode(File::get('app/Console/PythonWebScraper/data.json'), true, 2048);

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
            $station = Station::whereName($stationName)
                ->firstOrCreate([
                    'name' => $stationName,
                    'dining_center_id' => $diningCenter->id,
                ]);

            $this->foreachDates($stationInformation['dates'], $diningCenter, $station);
        }
    }

    public function foreachDates($dates, $diningCenter, $station = null)
    {
        foreach ($dates as $date => $currentMenu) {
            $start = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($date)));
            $end = Carbon::createFromFormat('Y-m-d', date('Y-m-d', strtotime($date)));
            $start->second(0)
                ->minute(0)
                ->hour(0);
            $end->second(0)
                ->minute(0)
                ->hour(0);

            $this->foreachMenus($currentMenu['meals'], $diningCenter, $start, $end, $station);
        }
    }

    public function foreachMenus($menu, $diningCenter, $start, $end, $station = null)
    {
        foreach ($menu as $menuName => $foods) {
            switch (strtolower($menuName)) {
                case "breakfast":
                    $start->hour(Menu::BREAKFAST_START);
                    $end->hour(Menu::BREAKFAST_END - 1)
                        ->minute(59)
                        ->second(59);
                    break;
                case "lunch":
                    $start->hour(Menu::LUNCH_START);
                    $end->hour(Menu::LUNCH_END - 1)
                        ->minute(59)
                        ->second(59);
                    break;
                case "dinner":
                    $start->hour(Menu::DINNER_START);
                    $end->hour(Menu::DINNER_END - 1)
                        ->minute(59)
                        ->second(59);
                    break;
                case "late night":
                    $start->hour(Menu::LATENIGHT_START);
                    $end->hour(Menu::LATENIGHT_END - 1)
                        ->minute(59)
                        ->second(59);
                    break;
                case "daily":
                    $end->hour(23)
                        ->minute(59)
                        ->second(59);
                    break;
            }
            $menu = Menu::where('dining_center_id', $diningCenter->id)
                ->where('station_id', $station ? $station->id : null)
                ->where('name', $menuName)
                ->where('start', $start)
                ->where('end', $end)
                ->firstOrCreate([
                    'dining_center_id' => $diningCenter->id,
                    'name' => $menuName,
                    'station_id' => $station ? $station->id : null,
                    'start' => $start,
                    'end' => $end,
                ]);

            $this->foreachFoods($foods['foods'], $menu);
        }
    }

    public function foreachFoods($foods, $menu)
    {
        foreach ($foods as $foodInfo) {
            $food = Food::where('name', $foodInfo['name'])
                ->firstOrCreate([
                    'name' => $foodInfo['name'],
                ]);

            $this->filterNutritionInformation($food, $foodInfo);

            $food->menus()->attach($menu->id);
        }
    }

    public function filterNutritionInformation($foodItem, $foodNutrition)
    {
        foreach (Nutrition::TYPES as $type) {
            if (array_key_exists($type, $foodNutrition)) {
                Nutrition::create([
                    'name' => $type,
                    'value' => $foodNutrition[$type],
                    'food_id' => $foodItem->id,
                ]);
            }
        }
    }
}