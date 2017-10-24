<?php

namespace App\Http\Controllers;

use App\Food;
use App\User;
use Illuminate\Support\Facades\DB;
use function compact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function max;

class FoodLogController extends Controller
{
    /**
     * @param Request $request
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
//        return $request->user()->foods()->attatch($food->id, [
//            'menu_id' => $request->input('menu-id'),
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//        ]);
    }

    /**
     * @param $id
     * @param $request
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

    public function addFoodLog(Request $request)
    {
        //Validate the info
        //might need to check same size array
        $this->validate($request,[
            //UNCOMMENT LATE
//            'foods'=> 'required|array',
//            'menus'=> 'required|array'
            'foods'=> 'required',
            'menus'=> 'required'
        ]);
        //LOGS is equal to the new value needed to enter.
        $user = $request->user();
        //$food = $user->food();
        $mealBundle = DB::table('food_logs')
            ->select('*')
            ->where('user_id', '=', $user->id)
            ->max('meal_id') + 1;
        //dd($mealBundle);

        return [
            'success' => true,
            DB::table('food_logs')
            ->insert([
                'food_id' => $request->foods,
                'menu_id' => $request->menus,
                'user_id' => $user->id,
                'meal_id' => $mealBundle,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]),
        ];
//            'meal_bundle' => $user
//            ->foods()
//            ->attach($user->food
//            ->id [
//                'meal_id'=> $mealBundle,
//
//
//                ])
//        ];
    }
}