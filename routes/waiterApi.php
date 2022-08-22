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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('getPhoto/{folder}/{name}', 'LoginController@getPhoto');
// Route::put('addItemToKitchen/{orderedItem}','OrderController@addItemToKitchen');

Route::group(['prefix' => 'waiter'], function () {
    Route::post('login','LoginController@Login');
    Route::group(['middleware' => ['auth:waiters']], function ()
    {
        Route::get('table','TableController@getTables');
        Route::post('table/transferTable','TableController@transfer');
        Route::post('table/mergeTable','TableController@merge');
        Route::get('table/{branchTable}','TableController@getTable');
        Route::put('table/{table}','TableController@checkout');
        Route::put('/turnOffCallWaiter/{branchTable}','TableController@turnOffCallWaiter');
        Route::put('addItemToKitchen/{orderedItem}','OrderController@addItemToKitchen');
        Route::put('removeItemToKitchen/{orderedItem}','OrderController@removeItemToKitchen');

        Route::get('/categories','ItemController@getCategories');
        Route::get('/items','ItemController@getItems');
        Route::put('/items/{item}','ItemController@updateItemAvailability');

        Route::get('Logout',"LoginController@Logout");
        Route::get('cart/{cart}', 'CartController@getCart');
        Route::post('cart/{cart}', 'CartController@addToCart');
        Route::put('cart/{cart}', 'CartController@editCartItem');
        Route::delete('cart/{cart}/{cartItem}', 'CartController@deleteCartItem');
        Route::post('/placeOrder/{cart}','OrderController@placeOrder');
        Route::get('/getItem/{item}', 'ItemController@getItem');
    });
});
