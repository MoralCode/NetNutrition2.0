<?php

namespace App\Http\Controllers;

use App\Food;
use App\User;
use Illuminate\Support\Facades\DB;
use function compact;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use function max;

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
     * @param $id
     * @param $request
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function showFoodLog($id, Request $request)
    {
        return User::whereId($request->user()->id)
            ->with([
                'foods' => User::getFilterMealBlocks($id),
                'menus' => User::getFilterMealBlocks($id)
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
        $this->validate($request,[
            'foods'=> 'required|array',
            'menus'=> 'required|array'
        ]);

        // Check that the sizes of the arrays are equal
        if(sizeof($request->input('foods')) != sizeof($request->input('menus'))) {
            return [
                'foods' => 'Arrays must be of same length',
                'menus' => 'Arrays must be of same length',
                'success' => false,
            ];
        }

        // Obtain the next db value for a given user's meal block value
        $mealBundle = DB::table('food_logs')
            ->select('*')
            ->where('user_id', '=', $request->user()->id)
            ->max('meal_id') + 1;

        // Loop through the two arrays
        $menus = $request->input('menus');
        foreach($request->input('foods') as $index => $food) {
            $menu = $menus[$index];

            $request->user()->foods()->attach($food, [
                'menu_id' => $menu,
                'meal_id' => $mealBundle,
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