<?php

namespace App\Http\Controllers;

use App\DiningCenter;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodLogController extends ApiController
{
    public function viewFoodOptions(Request $request, $diningCenterId)
    {
        return DiningCenter::select([
            'id',
            'name',
        ])->with(['menus' => function ($query) use ($request) {
            /** @var $query \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Relations\Relation */
            $query->select([
                'id',
                'name',
                'start',
                'end',
                'station_id',
                'dining_center_id',
            ]);

            switch ($request->input('type', 'current')) {
                case 'today':
                    $query->whereRaw("CURDATE() = DATE(start)");
                    break;
                case 'current':
                default:
                    $query->whereRaw("'" . Carbon::now()->toDateTimeString() . "' BETWEEN start AND end");
                    break;
            }

            $query->with(['station', 'foods' => function ($query) {
                /** @var $query \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Relations\Relation */
                $query->with(['nutritions', 'allergens']);
            }]);
        }])->findOrFail($diningCenterId);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(Request $request)
    {
        $date = $request->input('date', null) ?
            Carbon::createFromFormat('Y-m-d', $request->input('date')) :
            null;

        return User::whereId($request->user()->id)
            ->with([
                'foods' => function ($query) use ($date) {
                    /** @var $query Builder */
                    if ($date) {
                        $query->whereRaw("DAY(food_logs.created_at) = {$date->day}");
                        $query->whereRaw("MONTH(food_logs.created_at) = {$date->month}");
                        $query->whereRaw("YEAR(food_logs.created_at) = {$date->year}");
                    }
                    $query->with(['nutritions', 'allergens']);
                },
                'menus' => function ($query) use ($date) {
                    /** @var $query Builder */
                    if ($date) {
                        $query->whereRaw("DAY(food_logs.created_at) = {$date->day}");
                        $query->whereRaw("MONTH(food_logs.created_at) = {$date->month}");
                        $query->whereRaw("YEAR(food_logs.created_at) = {$date->year}");
                    }
                }
            ])
            ->get();
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function addFoodLog(Request $request)
    {
        //Validate the info
        $this->validate($request, [
            'foods' => 'required|array',
            'menus' => 'required|array',
            'servings' => 'required|array',
        ]);

        // Check that the sizes of the arrays are equal
        if (sizeof($request->input('foods')) != sizeof($request->input('menus')) ||
            sizeof($request->input('foods')) != sizeof($request->input('servings'))) {
            return [
                'foods' => 'Arrays must be of same length',
                'menus' => 'Arrays must be of same length',
                'servings' => 'Arrays must be of same length',
                'success' => false,
            ];
        }

        // Obtain the next db value for a given user's meal block value
        $mealBundle = DB::table('food_logs')
                ->select('*')
                ->where('user_id', '=', $request->user()->id)
                ->max('meal_block') + 1;

        // Loop through the two arrays
        $menus = $request->input('menus');
        $servings = $request->input('servings');
        foreach ($request->input('foods') as $index => $food) {
            $menu = $menus[$index];
            $serving = $servings[$index];

            $request->user()->foods()->attach($food, [
                'menu_id' => $menu,
                'meal_block' => $mealBundle,
                'servings' => $serving,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Return the newly added food logs
        return [
            'success' => true,
            'addedData' => $this->showFoodLog($mealBundle, $request)
        ];
    }

    /**
     * @param $mealBlock
     * @param $request
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function showFoodLog($mealBlock, Request $request)
    {
        return User::whereId($request->user()->id)
            ->with([
                'foods' => function ($query) use ($mealBlock) {
                    $query->with(['nutritions', 'allergens']);
                    $query->where('meal_block', '=', $mealBlock);
                },
                'menus' => function ($query) use ($mealBlock) {
                    $query->where('meal_block', '=', $mealBlock);
                },
            ])
            ->get();
    }

    /**
     * @param int $mealBlock
     * @param Request $request
     *
     * @return array
     */
    public function destroyMeal($mealBlock, Request $request)
    {
        return [
            'deletedMeal' => DB::table('food_logs')
                ->where([
                    ['meal_block', '=', $mealBlock],
                    ['user_id', '=', $request->user()->id],
                ])
                ->get(),
            'success' => boolval(DB::table('food_logs')
                ->where([
                    ['meal_block', '=', $mealBlock],
                    ['user_id', '=', $request->user()->id],
                ])
                ->delete()),
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroyItem($id)
    {
        return [
            'deletedItem' => DB::table('food_logs')
                ->where('id', '=', $id)
                ->first(),
            'success' => boolval(DB::table('food_logs')
                ->where('id', '=', $id)
                ->delete()),
        ];
    }
}