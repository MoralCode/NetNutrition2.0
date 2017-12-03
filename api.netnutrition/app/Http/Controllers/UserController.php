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

        $this->middleware('role:' . Role::ADMIN, [
            'except' => [
                'getRole',
            ],
        ]);
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function getRole(Request $request)
    {
        return $request->user()->role;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return User::with('role')->get();
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function show($id)
    {
        return User::findOrFail($id);
    }

    /**
     * @param $id
     * @param Request $request
     *
     * @return array
     */
    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);

        $this->validate($request, [
            'net_id' => 'sometimes|string|unique:users,net_id,' . $id,
            'role_id' => 'sometimes|between:' . Role::ADMIN . ',' . Role::STUDENT,
        ]);

        return [
            'success' => $user->update([
                'net_id' => $request->input('net_id', $user->net_id),
                'role_id' => $request->input('role_id', $user->role_id),
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
            'success' =>
                ($user = User::findOrFail($id))->role_id != Role::ADMIN ?
                    $user->delete() :
                    false,
        ];
    }
}