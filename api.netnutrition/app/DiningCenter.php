<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Illuminate\Database\Eloquent\Collection|Menu[] $menus
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DiningCenter findOrFail($id, $columns = array())
 * @mixin \Eloquent
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