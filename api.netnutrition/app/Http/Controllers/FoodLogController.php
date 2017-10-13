<?php

namespace App\Http\Controllers;

use App\FoodLog;

class FoodLogController
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return FoodLog::all();
    }

    /**
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function showFoodLog($id)
    {
        return FoodLog::findorfail($id);
    }
}