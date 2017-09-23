<?php

namespace App\Http\Controllers;

use App\DiningCenter;
use App\Food;
use App\Menu;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use function array_key_exists;
use function ini_set;
use function set_time_limit;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('users.dashboard');
    }
}