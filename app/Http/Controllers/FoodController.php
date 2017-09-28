<?php

namespace App\Http\Controllers;

use App\Food;
use Illuminate\Http\Request;

class FoodController extends ApiController
{
    //Return all food items
    public function index()
    {
        return Food::all();
    }
    //Return one food item
    public function show($id)
    {
        return Food::findOrFail($id);
    }
}