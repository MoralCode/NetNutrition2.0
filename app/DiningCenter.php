<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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