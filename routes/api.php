<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('test', function() {
  dd("FDSA");
});
Route::get('dining-list', 'DiningCenterController@listCenters');

//Food API Routes
Route::get('food-list', 'FoodController@listFoods');
Route::get('food-list/{$id}', 'FoodController@getFood');

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});