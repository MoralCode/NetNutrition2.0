<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Illuminate\Database\Eloquent\Collection|Menu[] $menus
 * @property \Illuminate\Database\Eloquent\Collection|Station[] $stations
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method Builder|DiningCenter findOrFail($id, $columns = array())
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class DiningCenter extends Model
{
    /** @var array */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stations()
    {
        return $this->hasMany(Station::class);
    }
}