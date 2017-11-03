<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;


class UserController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('role:' . Role::ADMIN);
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

    /**
     * @param $id
     * @return bool|null
     */
    public function remove($id)
    {
         if ( User::where('id', $id)
         ->delete() == 1)
         {
             return "user ".$id." was deleted";
         }
         else {
             return "error";
         }
    }

    public function update($id, Request $request)
    {
        User::where('id', $id)
            ->update([
                'net_id'=>$request->input('net_id'),
                'role_id'=>$request->input('role_id'),
            ]);
        return "please update";
    }
}