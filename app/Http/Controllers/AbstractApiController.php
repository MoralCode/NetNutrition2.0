<?php

namespace App\Http\Controllers;

class AbstractApiController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth',
        ]);
    }
}