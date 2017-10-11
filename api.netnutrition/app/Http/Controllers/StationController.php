<?php

namespace App\Http\Controllers;
use App\Food;
use App\Station;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StationController
{
    /**
     * returns all stations
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Station::all();
    }

    /**
     * @param $id
     * returns an individual station
     * @return Station|\Illuminate\Database\Eloquent\Builder
     */
    public function show($id)
    {
        return Station::findorfail($id);
    }

    /**
     * @param $id
     * returns the food at a station
     * @return mixed
     */
    public function showFoods($id)
    {
        return Station::findorfail($id)
            ->foods;
    }

    /**
     * @param $id
     * @return \Illuminate\Support\Collection|static
     */
    public function showNutritions($id)
    {
        return Station::findorfail($id)
            ->foods
            ->map(function ($food) {
                /** @var $food Food */
                $food->nutritions;
                return $food;
            });
    }

    public function showIngredients($id)
    {
        return Station::findOrFail($id)
            ->foods
            ->map(function ($food) {
                /** @var $food Food */
                $food->ingredients;
                return $food;
            });
    }
}