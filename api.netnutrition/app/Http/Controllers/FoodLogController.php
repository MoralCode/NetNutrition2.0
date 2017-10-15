<?php

namespace App\Http\Controllers;

use App\FoodLog;
use Illuminate\Http\Request;

class FoodLogController
{
    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index(Request $request)
    {
        return $request->user()->foods;
        //return FoodLog::where('user_id', $request->user()->id)->get();

//        $request->user()->foods()->attatch($food->id, [
//            'menu-id' => $request->input('menu-id'),
//            'created_at' => Carbon::now(),
//            'updated_at' => Carbon::now(),
//        ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function showFoodLog($id)
    {
        return FoodLog::findorfail($id);
    }

    public function addFoodLog(Request $request)
    {

    }
}