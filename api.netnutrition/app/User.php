<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use function explode;
use function str_random;
use function strpos;

/**
 * @property int $id
 * @property string $net_id
 * @property Role $role
 * @property \Carbon\Carbon $api_token_expiration
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static Builder|User[]  whereApiToken($token)
 * @method Builder|Station findOrFail($id, $columns = array())
 * @mixin \Illuminate\Database\Eloquent\Model
 */
class User extends Model
{
    /** @var array */
    protected $guarded = [];

    /** @var array */
    protected $dates = [
        'api_token_expiration',
        'created_at',
        'updated_at',
    ];

    public static function generateToken()
    {
        do {
            $token = str_random(32);

            $user = User::whereApiToken($token)->first();
        } while ($user);

        return $token;
    }

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
        $this->attributes['password'] = Hash::make($password);
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