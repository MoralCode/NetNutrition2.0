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
    Route::get('list-dining-centers', 'DiningCenterController@listDiningCenters')->name('api.list-dining-centers');
});