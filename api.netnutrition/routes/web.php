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

$router->get('/check-authorized', 'ApiController@checkAuthorized');

$router->post('/login', 'ApiController@login');
$router->get('/logout', 'ApiController@logout');
$router->post('/signup', 'ApiController@signup');

$router->group(['prefix' => 'dining-center'], function () use ($router) {
    $router->get('/', 'DiningCenterController@index');
    $router->get('/{id}', 'DiningCenterController@show');
    $router->get('/{id}/menus', 'DiningCenterController@showMenus');
    $router->get('/{id}/foods', 'DiningCenterController@showFoods');
    $router->get('/{id}/view-food-options', 'FoodLogController@viewfoodOptions');
});

$router->group(['prefix' => 'station'], function () use ($router) {
    $router->get('/', 'StationController@index');
    $router->get('/{id}', 'StationController@show');
    $router->get('/{id}/menus', 'StationController@showMenus');
    $router->get('/{id}/foods', 'StationController@showFoods');
});

$router->group(['prefix' => 'menu'], function () use ($router) {
    $router->get('/', 'MenuController@index');
    $router->get('/{id}', 'MenuController@show');
    $router->get('/{id}/foods', 'MenuController@showFoods');
    $router->get('/{id}/nutritions', 'MenuController@showNutritions');
    $router->get('/{id}/allergens', 'MenuController@showAllergens');
});

$router->group(['prefix' => 'food'], function () use ($router) {
    $router->get('/', 'FoodController@index');
    $router->get('/{id}', 'FoodController@show');
    $router->get('/{id}/nutritions', 'FoodController@showNutritions');
    $router->get('/{id}/allergens', 'FoodController@showAllergens');
});

$router->group(['prefix' => 'user'], function () use ($router) {
    $router->get('/', 'UserController@index');
    $router->get('/role', 'UserController@getRole');
    $router->get('/{id}', 'UserController@show');
    $router->post('/destroy/{id}', 'UserController@destroy');
    $router->post('/update/{id}', 'UserController@update');
});

$router->group(['prefix' => 'food-log'], function () use ($router) {
    $router->get('/', 'FoodLogController@index');
    $router->get('/{mealBlock}', 'FoodLogController@showFoodLog');
    $router->get('/do/add', 'FoodLogController@addFoodLog');
    $router->get('/destroy/meal-block/{mealBlock}', 'FoodLogController@destroyMeal');
    $router->post('/destroy/{id}', 'FoodLogController@destroyItem');
    $router->post('/update/{id}', 'FoodLogController@updateMeal');
});

$router->group(['prefix' => 'analytics'], function () use ($router) {
    $router->get('/most-eaten-food', 'FoodAnalytics@mostEatenFood');
    $router->get('/food-log-to-csv', 'FoodAnalytics@foodLogToCsv');
});