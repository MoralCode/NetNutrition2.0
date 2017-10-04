<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth', ['except' => 'login']);
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
            && Hash::check($request->input('password'), $user->password)) {

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
}