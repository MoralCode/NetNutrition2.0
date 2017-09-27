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
}