<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use function bcrypt;
use function explode;
use function strpos;

class User extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'net_id',
        'email',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Fetch the email for the associated user based off of net id
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->net_id . '@iastate.edu';
    }

    /**
     * @param $password string
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * @param $netId string
     */
    public function setNetIdAttribute($netId)
    {
        // Convert netId to just netId, no email address
        if (strpos($netId, '@')) {
            $netId = explode('@', $netId)[0];
        }

        $this->attributes['net_id'] = $netId;
    }
}
