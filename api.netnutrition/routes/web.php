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
$router->get('/logout','ApiController@logout');
$router->get('/signup','ApiController@signup');

$router->group(['prefix' => 'dining-center'], function () use ($router) {
    $router->get('/', 'DiningCenterController@index');
    $router->get('/{id}', 'DiningCenterController@show');
    $router->get('/{id}/menus', 'DiningCenterController@showMenus');
    $router->get('/{id}/foods', 'DiningCenterController@showFoods');
});

$router->group(['prefix' => 'menu'], function () use ($router) {
    $router->get('/', 'MenuController@index');
    $router->get('/{id}','MenuController@show');
    $router->get('/{id}/foods', 'MenuController@showFoods');
    $router->get('/{id}/nutritions', 'MenuController@showNutritions');
    $router->get('/{id}/ingredients','MenuController@showIngredients');
});

$router->group(['prefix' => 'food'], function () use ($router) {
    $router->get('/', 'FoodController@index');
    $router->get('/{id}', 'FoodController@show');
    $router->get('/{id}/nutritions', 'FoodController@showNutritions');
    $router->get('/{id}/ingredients', 'FoodController@showIngredients');
});

$router->group(['prefix' => 'user'], function () use ($router) {
    $router->get('/', 'UserController@index');
    $router->get('/{id}', 'UserController@show');
});
//    Route::group(['prefix' => 'food'], function () {
//        Route::get('/', 'FoodController@index')->name('api.food');
//        Route::get('/{id}', 'FoodController@show')->name('api.food.show');
//    });