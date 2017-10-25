<?php

namespace App\Http\Controllers;

use App\User;


class UserController
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return User::all();
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function show($id)
    {
        return User::where('id', $id)
            ->first();
    }
}