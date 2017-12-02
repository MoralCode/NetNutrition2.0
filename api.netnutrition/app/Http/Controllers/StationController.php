<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Station;

class StationController extends Controller
{
    /**
     * Returns all stations
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Station::all();
    }

    /**
     * Returns an individual station
     *
     * @param $id
     *
     * @return Station|\Illuminate\Database\Eloquent\Builder
     */
    public function show($id)
    {
        return Station::findorfail($id);
    }

    /**
     * Returns the food at a station
     *
     * @param $id
     *
     * @return \Illuminate\Support\Collection|static
     */
    public function showMenus($id)
    {
        return Station::findorfail($id)
            ->menus;
    }

    /**
     * Fetch all food information
     *
     * @param $id
     *
     * @return \Illuminate\Support\Collection|static
     */
    public function showFoods($id)
    {
        return Station::findorfail($id)
            ->menus
            ->map(function ($menu) {
                /** @var $menu Menu */
                $menu->foods;
                return $menu;
            });
    }
}