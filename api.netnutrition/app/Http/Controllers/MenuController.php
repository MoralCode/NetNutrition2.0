<?php

namespace App\Http\Controllers;

use App\Menu;

class MenuController extends ApiController
{
    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|mixed|\Model|null|static|static[]
     */
    public function showFoods($id)
    {
        return Menu::findOrFail($id)->food_items;
    }
}