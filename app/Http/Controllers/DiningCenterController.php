<?php

namespace App\Http\Controllers;

use App\DiningCenter;

class DiningCenterController extends AbstractApiController
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function listDiningCenters()
    {
        return DiningCenter::all();
    }
}