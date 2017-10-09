<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => [
                'login', 'signup'
            ]
        ]);
    }

    /**
     * @param Request $request
     *
     * @return array
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'net_id' => 'required|string',
            'password' => 'required|string',
        ]);

        if (($user = User::where('net_id', $request->input('net_id'))->first())
            && Hash::check($request->input('password'), $user->getOriginal('password'))) {

            $user->update([
                'api_token_expiration' => Carbon::now()->addHour(4),
                'api_token' => User::generateToken(),
            ]);

            return [
                'success' => true,
                'token' => $user->api_token,
            ];
        }

        return [
            'success' => false,
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function logout(Request $request)
    {
        $request->user()->update([
            'api_token' => null,
            'api_token_expiration' => null,
        ]);

        return [
            'success' => true,
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function signup(Request $request)
    {
        //check to see if net id and password fit perimeters
        $this->validate($request, [
            'net_id' => 'required|string|unique:users,net_id',
            'password' => 'required|string|min:8|confirmed',
        ]);

        //Create user
        return [
            'success' => true,
            'token' => User::create([
                'net_id' => $request->input('net_id'),
                'password' => $request->input('password'),
                'role_id' => Role::STUDENT,
                'api_token_expiration' => Carbon::now()->addHour(4),
                'api_token' => User::generateToken(),
            ])->api_token,
        ];
    }
}
