<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property Food $food
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method Builder|Nutrition findOrFail($id, $columns = array())
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class Nutrition extends Model
{
    const TYPES = [
        'Calories',
        'Cholesterol',
        'Dietary Fiber',
        'Protein',
        'Saturated Fat',
        'Sodium',
        'Total Carbohydrate',
        'Total Fat',
        'servingSize',
        'ingredients',
    ];

    /** @var array */
    protected $guarded = [];

    /** @var string */
    protected $table = 'nutritions';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}