<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property DiningCenter $dining_center
 * @property Station $station
 * @property \Illuminate\Database\Eloquent\Collection|Food[] $foods
 * @property \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property \Carbon\Carbon $start
 * @property \Carbon\Carbon $end
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method Builder|Menu findOrFail($id, $columns = ['*'])
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Menu extends Model
{
    const BREAKFAST_START = 0;
    const BREAKFAST_END = 10;

    const LUNCH_START = 10;
    const LUNCH_END = 15;

    const DINNER_START = 15;
    const DINNER_END = 21;

    const LATENIGHT_START = 21;
    const LATENIGHT_END = 24;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function foods()
    {
        return $this->belongsToMany(Food::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'food_logs')
            ->withPivot(['menu_id','meal_block', 'servings']);
    }
}