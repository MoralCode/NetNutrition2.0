<?php

namespace App\Http\Controllers;

use App\Food;

class FoodController extends ApiController
{
    /**
     * Returns all the food items
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Food::all();
    }
    /**
     * Returns one food item
     *
     * @param $id
     *
     * @return Food|\Illuminate\Database\Eloquent\Builder
     */
    public function show($id)
    {
        return Food::findOrFail($id);
    }

    /**
     * Returns nutritions of a specific food
     *
     * @param $id
     *
     * @return mixed
     */
    public function showNutritions($id)
    {
        return Food::findorfail($id)
            ->nutritions;
    }

    /**
     * Returns ingredients of a specific food
     *
     * @param $id
     *
     * @return mixed
     */
    public function showIngredients($id)
    {
        return Food::findorfail($id)
            ->ingredients;
    }
}