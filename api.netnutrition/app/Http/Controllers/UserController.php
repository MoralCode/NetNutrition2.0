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
        $this->validate($request, [
            'net_id' => 'string|unique:users,net_id',
            'role_id' => 'integer|between:1,3',
        ]);

        return [
            'success' => User::findOrFail($id)
                ->update([
                    'net_id' => $request->input('net_id'),
                    'role_id' => $request->input('role_id'),
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