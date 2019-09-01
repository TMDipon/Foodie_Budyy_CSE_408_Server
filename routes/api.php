<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/createUser','User_controller@createUser');
Route::post('/loginUser','User_controller@loginUser');
Route::post('/createOwner','Owner_controller@createOwner');
Route::post('/loginOwner','Owner_controller@loginOwner');
Route::post('/modifyRestaurant','Owner_controller@modifyRestaurant');
Route::post('/delshowfood','Owner_controller@showfoodByRestaurant');
Route::post('/deleteFood','Owner_controller@deleteFood');
Route::post('/changeFoodPrice','Owner_controller@changeFoodPrice');
Route::post('/createRestaurant','Restaurant_controller@createRestaurant');
Route::post('/insertFood','FoodInsert_controller@insertFood');
Route::get('/restaurants','userProfile_controller@restaurants');
Route::post('/foodByRestaurant','userProfile_controller@foodByRestaurant');
Route::post('/placeOrder','userProfile_controller@storeOrder');
Route::post('/searchOrders','Order_controller@searchOrders');

//Rider url's
Route::post('/createRider','Rider_controller@createRider');
Route::post('/loginRider','Rider_controller@loginRider');
Route::post('/acceptOrder','Order_controller@acceptOrder');
Route::post('/rejectOrder','Order_controller@rejectOrder');
Route::post('/updateOrderStatus','Order_controller@updateOrderStatus');