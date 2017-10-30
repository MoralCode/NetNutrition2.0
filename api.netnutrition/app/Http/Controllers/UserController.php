<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;


class UserController extends ApiController
{
    public function __construct()
    {
        $this->middleware('role:' . Role::ADMIN);
        parent::__construct();
    }

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