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
        //Eventually want to NOT return passwords and token
        return User::all();
    }

    public function show($id)
    {
        return User::findorfail($id);
    }
}