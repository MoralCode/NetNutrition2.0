<?php

namespace App\Http\Controllers;

use App\Food;
use App\User;
use Illuminate\Http\Request;

class FoodLogController
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index( Request $request)
    {
        //BELOW IS CORRECT
        return $request->user()->foods;
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
        return $request->user()->foods()->wherePivot('meal_id','=', $id)->get();
    }

    public function addFoodLog(Request $request)
    {
        //Take in info


    }
}