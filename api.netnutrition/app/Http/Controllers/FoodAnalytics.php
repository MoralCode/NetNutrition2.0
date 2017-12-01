<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function arrayToCsv;

class FoodAnalytics extends ApiController
{
    public function mostEatenFood()
    {
        return DB::select('
            SELECT
              *,
              COUNT(fl.food_id) AS numberEntries
            FROM food_logs AS fl
              LEFT JOIN foods AS f ON f.id = fl.food_id
            GROUP BY fl.food_id
            ORDER BY numberEntries DESC
            LIMIT 1;
        ');
    }

    public function foodLogToCsv(Request $request)
    {
        return $this->arrayToCsv(User::whereId($request->user()->id)
            ->with([
                'foods' => function ($query) {
                    $query->with(['nutritions', 'allergens']);
                },
                'menus' => function ($query) {
                },
            ])
            ->get());
    }

    protected function arrayToCsv($array)
    {
        $csv = array();
        foreach ($array as $item) {
            if (is_array($item)) {
                $csv[] = $this->arrayToCsv($item);
            } else {
                $csv[] = $item;
            }
        }
        return implode(',', $csv);
    }
}