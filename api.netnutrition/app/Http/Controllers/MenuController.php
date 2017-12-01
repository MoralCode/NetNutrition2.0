<?php

namespace App\Http\Controllers;

use App\Food;
use App\Menu;

class MenuController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Menu::all();
    }

    /**
     * @param $id
     *
     * @return Menu|\Illuminate\Database\Eloquent\Builder
     */
    public function show($id)
    {
        return Menu::findOrFail($id);
    }

    /**
     * @param $id
     *
     * @return \App\Food[]|\Illuminate\Database\Eloquent\Collection
     */
    public function showFoods($id)
    {
        return Menu::findOrFail($id)
            ->foods;
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Support\Collection|static
     */
    public function showNutritions($id)
    {
        return Menu::findOrFail($id)
            ->foods
            ->map(function ($food) {
                /** @var $food Food */
                $food->nutritions;
                return $food;
            });
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Support\Collection|static
     */
    public function showIngredients($id)
    {
        return Menu::findOrFail($id)
            ->foods
            ->map(function ($food) {
                /** @var $food Food */
                $food->ingredients;
                return $food;
            });
    }
}