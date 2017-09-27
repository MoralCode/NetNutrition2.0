<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Route;
use function collect;
use function str_contains;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth',
        ]);
    }

    /**
     * @return Collection
     */
    public function index()
    {
        return collect(Route::getRoutes()->getRoutes())->map(function ($route) {
            if (str_contains($route->uri, 'api')) {
                return $route->uri;
            }
            return null;
        })->filter();
    }
}