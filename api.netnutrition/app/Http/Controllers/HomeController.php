<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware([
            'guest',
        ]);
    }

    public function welcome()
    {
        return view('welcome');
    }
}