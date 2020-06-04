<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'Auth\AuthController@login')->name('login');
    Route::post('register', 'Auth\AuthController@register');
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', 'Auth\AuthController@logout');
        Route::resource('getRideBookHistoryOffer', 'RideOfferController');
        Route::get('user', 'Auth\AuthController@user');
        Route::resource('avatar','AvatarController');
    });

});
Route::group([
    'middleware' => 'auth:api'
], function () {
    Route::group([
        'prefix' => 'ride'
    ], function () {
        Route::resource('rideActivity', 'RideActivityController');
        Route::resource('vehicles', 'VehicleController');
        Route::patch('rideOffer/changeStatus/{id}','RideOfferController@changeStatus');
        Route::resource('rideOffer', 'RideOfferController');
        Route::resource('bookRide', 'BookRideController');
        Route::resource('rideCurrent', 'RideCurrentController');
        Route::resource('customerOrders', 'CustomerOrdersController');
    });
    // menu routesc
    Route::group([
        'prefix' => 'menu'
    ], function () {
        Route::get('/menuItems/sp/{id}', 'MenuItemsController@spMenu');
        Route::resource('/menuItems', 'MenuItemsController');
        Route::get('/itemGroups/serviceType/{option}', 'MenuItemGroupController@index');
        Route::resource('/itemGroups','MenuItemGroupController');
        Route::resource('/serviceProviders', 'CHRLServiceProvidersController');
        Route::get('/serviceCatagories/serviceType/{option}', 'CHRLServiceProvidersController@index');
        Route::resource('/serviceCatagories', 'ServiceCatagoriesController');
        Route::resource('/customerOrders','CustomerOrdersController');
    });

});
Route::group([
    'prefix' => 'pictures'
], function () {
    Route::get('itemsGroup/{filename}', 'ImageService@itemGroupImage');
    Route::get('menuItem/{filename}', 'ImageService@menuItemImage');
    Route::get('avatar/{imageName?}','ImageService@avatar');
    Route::get('sPLogo/{imageName?}','ImageService@sPLogo');
    Route::get('sPCatagory/{imageName?}','ImageService@sPCatagory');
});
Route::get('VehicleList', 'VehicleListController@getVehicleData');
