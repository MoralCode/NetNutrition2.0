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
        $users = User::all(['id','net_id','role_id','api_token_expiration','created_at','updated_at']);
        return $users;
    }

    public function show($id)
    {
        return User::where('id',$id)->get(['id','net_id','role_id','api_token_expiration','created_at','updated_at']);
    }
}