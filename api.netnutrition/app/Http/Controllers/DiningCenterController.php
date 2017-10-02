<?php

namespace App\Http\Controllers;

use App\DiningCenter;
use App\Food;
use App\Menu;
use App\Nutrition;
use App\Station;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\File;
use function array_key_exists;
use function strtolower;
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
        return DiningCenter::findOrFail($id)->menus;
    }

    /**
     * @param $id
     *
     * @return Collection
     */
    public function showFoods($id)
    {
        $foodCollection = new Collection();
        foreach (DiningCenter::findOrFail($id)->menus as $menu) {
            foreach ($menu->food_items as $food) {
                if (!$foodCollection->contains($food)) {
                    $foodCollection->add($food);
                }
            }
        }

        return $foodCollection;
    }
}