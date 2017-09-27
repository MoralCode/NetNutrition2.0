<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DiningCenter findOrFail($id, $columns = array())
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
}