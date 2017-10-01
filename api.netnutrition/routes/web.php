<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Laravel\Lumen\Routing\Router;

/** @var $router Router */

$router->get('/login', 'ApiController@login');

$router->group(['prefix' => 'dining-center'], function () use ($router) {
    $router->get('/', 'DiningCenterController@index');
});


//        Route::get('/{id}', 'DiningCenterController@show')->name('api.dining-center.show');
//        Route::get('/{id}/menus', 'DiningCenterController@showMenus')->name('api.dining-center.showMenus');
//        Route::get('/{id}/foods', 'DiningCenterController@showFoods')->name('api.dining-center.showFoods');
//    });
//
//    Route::group(['prefix' => 'menu'], function () {
//        Route::get('/{id}/foods', 'MenuController@showFoods')->name('api.menu.showFoods');
//    });
//
//    Route::group(['prefix' => 'food'], function () {
//        Route::get('/', 'FoodController@index')->name('api.food');
//        Route::get('/{id}', 'FoodController@show')->name('api.food.show');
//    });