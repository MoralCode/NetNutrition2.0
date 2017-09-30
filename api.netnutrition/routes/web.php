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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

//Route::get('/', 'HomeController@welcome')->name('welcome');
//
//Route::redirect('/home', '/');
//Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');
//
//Auth::routes();
//
//Route::group(['prefix' => 'api'], function () {
//    Route::get('/', 'ApiController@index')->name('api.index');
//
//    Route::group(['prefix' => 'dining-center'], function () {
//        Route::get('/', 'DiningCenterController@index')->name('api.dining-center.index');
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
//});