<?php

namespace App\Http\Controllers;

use App\DiningCenter;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FoodSelectionController extends ApiController
{
    public function viewFoodOptions(Request $request, $diningCenterId)
    {
        return DiningCenter::select([
            'id',
            'name',
        ])->with(['stations' => function ($query) {
            /** @var $query \Illuminate\Database\Query\Builder */
            $query->select([
                'id',
                'name',
                'dining_center_id',
            ]);
        }, 'menus' => function ($query) use ($request) {
            /** @var $query \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Relations\Relation */
            $query->select([
                'id',
                'name',
                'start',
                'end',
                'station_id',
                'dining_center_id',
            ]);

            switch ($request->input('type', 'current')) {
                case 'today':
                    $query->whereRaw("CURDATE() = DATE(start)");
                    break;
                case 'current':
                default:
                    $query->whereRaw("'" . Carbon::now()->toDateTimeString() . "' BETWEEN start AND end");
                    break;
            }

            $query->with(['foods' => function ($query) {
                $query->with(['nutritions']);
            }]);
        }])->findOrFail($diningCenterId);
    }
}