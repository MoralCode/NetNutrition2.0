<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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