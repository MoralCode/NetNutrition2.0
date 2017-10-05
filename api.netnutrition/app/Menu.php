<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * property \Illuminate\Database\Eloquent\Collection|Food[] $foods
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Menu findOrFail($id, $columns = array())
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
}