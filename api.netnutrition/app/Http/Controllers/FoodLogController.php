<?php

namespace App\Http\Controllers;

use App\Food;
use App\User;
use Illuminate\Support\Facades\DB;
use function compact;
use Illuminate\Http\Request;
use function max;

class FoodLogController
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
        //Take in info
        //LOGS is equal to the new value needed to enter.
        $user = $request->user();
        $logs = DB::table('food_logs')
            ->select('*')
            ->where('user_id', '=', $user->id)
            ->max('meal_id') + 1;
        dd($logs);

    }
}