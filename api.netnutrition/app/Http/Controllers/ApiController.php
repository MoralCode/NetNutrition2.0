<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Route;

class ApiController extends Controller
{
    /**
     * ApiController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param Request $request
     *
     * @return Collection
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'net_id' => 'required|string',
            'password' => 'required|string',
        ]);

        Auth::attempt([
            'net_id' => $request->input('net_id'),
            'password' => $request->input('password'),
        ]);
    }
}