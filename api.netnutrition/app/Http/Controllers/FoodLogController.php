<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FoodLogController extends ApiController
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(Request $request)
    {
        return User::whereId($request->user()->id)
            ->with([
                'foods',
                'menus'
            ])
            ->get();
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
                'foods' => User::getFilterMealBlocks($mealBlock),
                'menus' => User::getFilterMealBlocks($mealBlock),
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
}