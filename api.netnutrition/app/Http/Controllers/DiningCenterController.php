<?php

namespace App\Http\Controllers;

use App\DiningCenter;
use App\Menu;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use function var_dump;

class DiningCenterController extends ApiController
{
    public function index()
    {
        return DiningCenter::all();
    }

    /**
     * @param $id
     *
     * @return DiningCenter|\Illuminate\Database\Eloquent\Builder|Collection|\Illuminate\Database\Eloquent\Model
     */
    public function show($id)
    {
        return DiningCenter::findOrFail($id);
    }

    /**
     * @param $id
     *
     * @return \App\Menu[]|Collection|mixed
     */
    public function showMenus($id)
    {
        return DiningCenter::findOrFail($id)
            ->menus;
    }

    /**
     * @param $id
     * @param Request $request
     *
     * @return Collection
     */
    public function showFoods($id, Request $request)
    {
        return DiningCenter::findOrFail($id)
            ->menus
            ->map(function ($menu) use ($request) {
                /** @var $menu Menu */
                if ($request->input('byDay', '') == 'true') {
                    if (!Carbon::now()->between($menu->start, $menu->end)) {
                        return null;
                    }
                }

                $menu->foods;
                return $menu;
            })->filter();
    }
}