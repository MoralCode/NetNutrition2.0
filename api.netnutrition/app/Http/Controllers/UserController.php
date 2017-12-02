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
     * @param Request $request
     *
     * @return array
     */
    public function update($id, Request $request)
    {
//        $this->validate($request, [
//            'net_id' => 'string|unique:users,net_id',
//            'role_id' => "integer|between:" . Role::ADMIN . "," . Role::STUDENT,
//        ]);

        //dd('here');
        $NetID = $request->input('net_id');
//        //If user inputs the same username they already have
//        if ($NetID == User::findorfail($id)->net_id){
//            $NetID = null;
//        };
        if ($NetID == null){
            //No net id specified so set to what it was
            $NetID = User::findorfail($id)->net_id;
            //Only validate the role id
            $this->validate($request, [
            'role_id' => "integer|between:" . Role::ADMIN . "," . Role::STUDENT,
            ]);
        };

        $RoleID = $request->input('role_id');
        if ($RoleID == null){
            //No role id specified so set to what it was
            $RoleID = User::findorfail($id)->role_id;
            //Only validate the net_id
            $this->validate($request, [
            'net_id' => 'string|unique:users,net_id',
            ]);
        };

        //
        if($NetID != null && $RoleID != null && $NetID != User::findorfail($id)->net_id)
            //dd($NetID);
        $this->validate($request, [
            'net_id' => 'string|unique:users,net_id',
            'role_id' => 'integer|between:1,3',
        ]);

        return [
            'success' => User::findOrFail($id)
                ->update([
                    'net_id' => $NetID,
                    'role_id' => $RoleID,
                ]),
        ];
    }

    /**
     * @param $id
     *
     * @return array
     */
    public function destroy($id)
    {
        return [
            'success' => User::findOrFail($id)
                ->delete(),
        ];
    }
}