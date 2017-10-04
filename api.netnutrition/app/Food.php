<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Food findOrFail($id, $columns = array())
 */
class Food extends Model
{
    /** @var array */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ingredients()
    {
        return $this->belongsToMany(Ingredient::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nutritions()
    {
        return $this->hasMany(Nutrition::class);
    }
}