<?php

namespace App\Http\Controllers;

use App\DiningCenter;
use App\Menu;
use App\Station;
use Carbon\Carbon;

class FoodSelectionController extends ApiController
{
    public function viewFoodOptions($diningCenterId)
    {
        /** @var DiningCenter $diningCenter */
        $diningCenter = DiningCenter::select([
            'id',
            'name',
        ])->findOrFail($diningCenterId);

        /** @var Station[]|\Illuminate\Database\Eloquent\Collection $stations */
        $diningCenter['stations'] = $diningCenter->stations()
            ->select([
                'id',
                'name',
            ])->get();

        $diningCenter['menus'] = $diningCenter->menus()
            ->select([
                'id',
                'name',
                'start',
                'end',
                'station_id',
            ])->whereRaw("'" . Carbon::now()->toDateTimeString() . "' BETWEEN start AND end")
            ->get();

        foreach ($diningCenter['menus'] as $key => $menu) {
            /** @var Menu $menu */
            $diningCenter['menus'][$key]['foods'] = $menu->foods()
                ->select([
                    'foods.id',
                    'foods.name',
                ])
                ->get()->map(function ($food) {
                    unset($food['pivot']);

                    $food['nutritions'] = $food->nutritions()
                    ->select([
                        'name',
                        'value'
                    ])->get();

                    return $food;
                });
        }

        return [
            $diningCenter
        ];
    }
}