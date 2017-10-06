<?php

namespace App\Http\Controllers;

use App\Menu;
use function PHPSTORM_META\map;

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

    public function showFoods($id)
    {
        return Menu::findorfail($id)
            ->foods;
    }

    public function showNutritions($id)
    {
        return Menu::findorfail($id)
            ->foods
        ->map(function($food){
            $food->nutritions;
            return $food;
        });
    }

    public function showIngredients($id)
    {
        return Menu::findorfail($id)
            ->foods
            ->map(function($food){
                $food->ingredients;
                return $food;
            });
    }
}