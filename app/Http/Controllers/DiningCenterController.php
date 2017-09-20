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
        // Fake data
        return factory(DiningCenter::class, 10)->make();

        // Real data
        //return DiningCenter::all();
    }
}