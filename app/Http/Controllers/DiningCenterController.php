<?php

namespace App\Http\Controllers;

use App\DiningCenter;
use function factory;

class DiningCenterController extends Controller
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function listCenters()
    {
        return factory(DiningCenter::class, 30)->make();
        //return DiningCenter::all();
    }
}