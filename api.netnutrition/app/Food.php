<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Illuminate\Database\Eloquent\Collection|Menu[] $menus
 * @property \Illuminate\Database\Eloquent\Collection|Ingredient[] $ingredients
 * @property \Illuminate\Database\Eloquent\Collection|Nutrition[] $nutritions
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method Builder|Food findOrFail($id, $columns = array())
 * @mixin \Illuminate\Database\Eloquent\Model
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'food_logs')
            ->withPivot([
                'menu_id',
                'meal_block',
                'servings',
                'created_at',
            ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nutritions()
    {
        return $this->hasMany(Nutrition::class);
    }
}