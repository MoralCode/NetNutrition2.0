<?php

namespace App\Http\Controllers;

use App\Food;
use Illuminate\Http\Request;

class FoodController extends AbstractApiController
{
    //Return all food items
    public function listFoods()
    {
        return Food::all();
    }
    //Return one food item
    public function getFood($id)
    {
        return Food::findOrFail($id);
    }
}
