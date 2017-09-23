<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use function is_array;

class Menu extends Model
{
    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected $dates = [
        'created_at',
        'updated_at',
        'start',
        'end',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function diningCenter()
    {
        return $this->belongsTo(DiningCenter::class);
    }



    /**
     * @param $foodItems string (json)
     *
     * @return \Illuminate\Database\Eloquent\Collection|Model|null|static|static[]
     */
    public function getFoodItemsAttribute($foodItems)
    {
        return Food::find(json_decode($foodItems, true));
    }

    public function setFoodItemsAttribute($foodItems)
    {
        if (!is_array($foodItems) && !$foodItems instanceof Collection) {
            $foodItems = [
                0 => $foodItems,
            ];
        }

        if ($foodItems[0] instanceof Food) {
            // Check that all food ids exist
            $foodItems = Food::findOrFail($foodItems)->map(function ($food) {
                return $food->id;
            });
        }

        $this->attributes['food_items'] = $foodItems->toJson();
    }
}