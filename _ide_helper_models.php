<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

namespace App {

<<<<<<< HEAD
namespace App{
/**
 * App\Role
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App{
/**
 * App\DiningCenter
 *
 * @property int $id
 * @property string $name
 * @property float $latitude
 * @property float $longitude
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Menu[] $menus
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DiningCenter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DiningCenter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DiningCenter whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DiningCenter whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DiningCenter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DiningCenter whereUpdatedAt($value)
 */
	class DiningCenter extends \Eloquent {}
}

namespace App{
/**
 * App\Food
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Food whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Food whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Food whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Food whereUpdatedAt($value)
 */
	class Food extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $net_id
 * @property string $password
 * @property int $role_id
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \App\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
=======
    /**
     * App\User
     *
     * @property int $id
     * @property string $net_id
     * @property string $password
     * @property string|null $remember_token
     * @property \Carbon\Carbon|null $created_at
     * @property \Carbon\Carbon|null $updated_at
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNetId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
     */
    class User extends \Eloquent
    {
    }
>>>>>>> develop
}

