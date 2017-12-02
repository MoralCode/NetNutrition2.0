<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Illuminate\Database\Eloquent\Collection|Food[] $foods
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method Builder|Allergen findOrFail($id, $columns = array())
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Allergen extends Model
{
    /** @var array */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function foods()
    {
        return $this->belongsToMany(Food::class);
    }
}