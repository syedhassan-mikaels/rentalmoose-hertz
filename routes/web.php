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

Route::get('/', function () {
    return view('welcome');
});

Route::group([], function(){
    Route::get('available-car-station', ['as' => 'available_car_station', 'uses' => 'HomeController@getAvailableCarsByLocation']);
    Route::get('import-car-station', ['as' => 'import_car_station', 'uses' => 'HomeController@displayCarStationForm']);
    Route::post('upload-car-station', ['as' => 'upload_car_station', 'uses' => 'HomeController@uploadCarStation']);
});
