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
    Route::get('email/verify/{id}', 'VerificationApiController@verify')->name('verificationapi.verify');
    Route::get('email/resend/{email}', 'VerificationApiController@resend')->name('verificationapi.resend');
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', 'Auth\AuthController@logout');
        Route::resource('getRideBookHistoryOffer', 'RideOfferController');
        Route::get('user', 'Auth\AuthController@user');
        Route::resource('avatar','AvatarController');
        Route::resource('identityCard', 'IdentityCardPictureController');
        Route::post('contact-us', 'ContactUsController@store');
    });
    Route::group([
        'namespace' => 'Auth',
        'prefix' => 'password'
    ], function () {
        Route::post('forgot', 'ForgotPasswordController@forgot');
        Route::post('reset', 'ForgotPasswordController@reset');
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
        Route::resource('/rating','RatingController');
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
