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
              SUM(fl.servings) AS totalServings
            FROM food_logs AS fl
              LEFT JOIN foods AS f ON f.id = fl.food_id
            GROUP BY fl.food_id
            ORDER BY totalServings DESC
            LIMIT 10;
        ');
    }

    public function mostEatenFoodByCenter($id)
    {
        return DB::select("
            SELECT
              COUNT(f.id)        AS totalEntries,
              f.id               AS foodID,
              f.name             AS foodName,
              fm.menu_id         AS foodMenuMenuId,
              fm.food_id         AS foodMenuFoodId,
              m.name             AS menuName,
              m.dining_center_id AS diningCenterId,
              dc.name            AS diningCenterName,
              fl.menu_id         AS foodLogMenuId,
              fl.food_id         AS foodLogFoodId
            FROM
              foods AS f
              LEFT JOIN food_menu AS fm ON fm.food_id = f.id
              LEFT JOIN menus AS m ON m.id = fm.menu_id
              LEFT JOIN dining_centers AS dc ON dc.id = m.dining_center_id
              LEFT JOIN food_logs AS fl ON fl.menu_id = m.id AND fl.food_id = f.id
            WHERE
              dc.id = {$id}
              AND
              fl.menu_id IS NOT NULL
              AND
              fl.food_id IS NOT NULL
            GROUP BY
              f.id, m.id
            ORDER BY
              totalEntries DESC
            LIMIT 10;
        ");
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