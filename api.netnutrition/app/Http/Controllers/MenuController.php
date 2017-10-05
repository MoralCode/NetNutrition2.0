<?php

namespace App\Http\Controllers;

use App\Menu;

class MenuController extends ApiController
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Menu::all();
    }

    public function show($id)
    {
        return Menu::findOrFail($id);
    }

    public function showFoods()
    {

    }

    public function showNutritions()
    {

    }

    public function showIngredients()
    {

    }
}