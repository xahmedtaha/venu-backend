<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware'=> ['app_version', 'cors']],function (){
    //tables
    Route::get('/testfirestore','OrderController@testFirestore');
    Route::get('/getToken','GuestController@getToken');
    Route::group(['prefix'=>'/','middleware' => 'auth:users,guest'], function ()
    {
        Route::get('/getProfile','UserController@getProfile');
        Route::put('/profile','UserController@editProfile');
        Route::get('/getRestuarants', 'ResturantController@getResturants');
        Route::get('/getRatedResturants', 'ResturantController@getRatedResturants');
        Route::get('/getAllResturants', 'ResturantController@getAllResturants');
        Route::get('/getChoosenResturants', 'ResturantController@getChoosenResturants');
        Route::get('/getNearbyResturants', 'ResturantController@getNearbyResturants');
        Route::get('/getCategories', 'ResturantController@getCategories');
        Route::get('/getPlaces', 'GuestController@getPlaces');
        Route::get('/getTerms', 'GuestController@getTerms');
        Route::get('/getOptions', 'GuestController@getOptions');
        Route::get('/GetLastOrder', 'GuestController@GetLastOrder');

        Route::get('/seacrhInRestaurants', 'ResturantController@seacrhInResturants');
        Route::put('rateResturant', 'ResturantController@rate');

    });

    Route::group(['prefix'=>'/','middleware'=>['auth:users','location']], function ()
    {
        //table
        Route::get('/scanQrCode/{tableHash}','TableController@scanTable');
        Route::get('/scanQrCode/{tableHash}/{nfcUid}','TableController@scanTableV2');
        Route::get('/scanQrCode/scanSharedTable/{tableShareCode}','TableController@scanSharedTable');

        //cart
        Route::group(['middleware' => ['activeCart','inBranch']], function () {
            Route::put('/callWaiter','TableController@callWaiter');
            Route::get('cart/{cart}', 'CartController@getCart');
            Route::post('cart/{cart}', 'CartController@addToCart');
            Route::put('cart/{cart}', 'CartController@editCartItem');
            Route::delete('cart/{cart}/{cartItem}', 'CartController@deleteCartItem');

            //Items
            Route::get('/getRestuarantItems', 'ItemController@getRestuarantItems');
            Route::get('/getItemLists', 'ItemController@getItemLists');
            Route::get('/getItem/{item}', 'ItemController@getItem');

            //Orders
            Route::post('/placeOrder','OrderController@placeOrder');
            Route::get('/getPlacedOrder','OrderController@getPlacedOrder');
            Route::post('/checkout', 'OrderController@checkout');
        });

        //Orders
        Route::get('/getPastOrders','OrderController@getOrders');
        Route::get('/getOrderDetails/{order}', 'OrderController@getOrderDetails');

        //UserData
        Route::post('/addAddress', 'UserController@addAddress');
        Route::put('/changeUserData', 'UserController@changeUserData');
        Route::put('/changeLanguage', 'UserController@changeLanguage');
        Route::put('/addPhone', 'UserController@addPhone');
        Route::get('/logout', 'UserController@logout');


        Route::get('/getProductsCategories', 'ItemController@getProductsCategories');
        Route::get('/getRestuarantSubProducts', 'ItemController@getRestuarantSubProducts');


        //Resturants
        Route::get('/getRestuarant/{resturantId}', 'ResturantController@getRestuarant')->name('userApi.getResturant');
        Route::get('checkRate', 'ResturantController@checkRate');



        // Route::get('/getOrders', 'OrderController@getOrders');
        // Route::get('/getOrderDetails/{orderId}', 'OrderController@getOrderDetails')->name('userApi.getOrderDetails');

        //Notifications
        Route::get('/getNotifications', 'NotificationsController@getNotifications');

        //Feedback
        Route::get('/getFeedbackReasons', 'UserFeedbackController@getFeedbackReasons');
        Route::post('/addFeedback', 'UserFeedbackController@addFeedback');
        Route::get('/getFeedbacks', 'UserFeedbackController@getFeedbacks');
        Route::post('/sendFeedback', 'UserFeedbackController@sendFeedback');
        Route::get('/getFeedbackResponse', 'UserFeedbackController@getFeedbackResponse');


    });

    // Route::post('/register','UserController@register')->middleware('auth:guest');
    Route::post('/register','UserController@register');
    // Route::post('/phoneLogin','UserController@phoneLogin')->middleware('auth:guest');
    Route::post('/phoneLogin','UserController@phoneLogin');
    Route::post('/verifyPhone', 'UserController@verifyPhone');

    // Route::post('/socialLogin','UserController@socialLogin')->middleware('auth:guest');

    Route::get('/verify_version',function () {
        return response()->json(config('app_versions.current'));
    });
});
