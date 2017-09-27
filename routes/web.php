<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@welcome')->name('welcome');

Route::redirect('/home', '/');
Route::get('/dashboard', 'DashboardController@dashboard')->name('dashboard');

Auth::routes();

Route::group(['prefix' => 'api'], function () {
    Route::get('/', 'ApiController@index')->name('api.index');

    Route::group(['prefix' => 'dining-center'], function () {
        Route::get('/', 'DiningCenterController@index')->name('api.dining-center.index');
        Route::get('/{id}', 'DiningCenterController@show')->name('api.dining-center.show');
        Route::get('/{id}/menus', 'DiningCenterController@showMenus')->name('api.dining-center.showMenus');
        Route::get('/{id}/foods', 'DiningCenterController@showFoods')->name('api.dining-center.showFoods');
    });

    Route::group(['prefix' => 'menu'], function () {
        Route::get('/{id}/foods', 'MenuController@showFoods')->name('api.menu.showFoods');
    });
});