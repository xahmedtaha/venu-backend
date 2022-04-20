<?php

use App\FirestoreOperations;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\Orders;
use App\Models\BranchTable;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderedItem;
use App\Models\Resturant;
use App\Models\User;

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

Route::get('/get_branchs/{id}','WaiterController@get_branchs');
Route::get('testOrange', function () {
    User::sendVerificationSMS("01001063536", "1234");
});
Route::get('test',function (){
//    event(new \App\Events\TableClosedEvent(BranchTable::first()));
    FirestoreOperations::getInstance()->updateTable(BranchTable::first(),[FirestoreOperations::TABLE_HAS_NEW_ITEMS=>false]);
});

Route::get('test2',function (){
//    event(new \App\Events\TableTransferredEvent(BranchTable::first(),BranchTable::latest()->first()));
    dd(BranchTable::first()->userIds());
//    FirestoreOperations::getInstance()->pushBulkEvent(12,['type'=>'transfer']);
});
Route::get('/a7a',function () {
    $service = 14;
    $subTotal = 100;
    $tax = 14;
    $serviceValue = ($service / 100) * $subTotal;
    $taxValue = ($tax / 100) * ($subTotal + $serviceValue);
    $total = $subTotal + $taxValue + $serviceValue;
    dd($total,$serviceValue,$taxValue);
});
Route::get('/',function()
{
    return redirect('/admin');
});

Route::get('/testfirebase','HomeController@testFirebase');

Route::group(['prefix' => 'admin'], function ()
{
    Auth::routes(['register' => false]);

    Route::group(['middleware' => ['auth']], function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('categories', 'CategoryController');

        //Resturants
        Route::get('resturants/getCategories', 'ResturantController@getCategories')->name('resturants.ajax.getCategories');
        Route::get('reviews','ResturantController@reviews')->name('resturants.reviews');

        Route::get('resturants/sortAll','ResturantController@sortAll')->name('resturants.sortAll');
        Route::post('resturants/sortAll','ResturantController@sortAllSubmit')->name('resturants.sortAll.store');

        Route::get('resturants/sortChoosen','ResturantController@sortChoosen')->name('resturants.sortChoosen');
        Route::post('resturants/sortChoosen','ResturantController@sortChoosenSubmit')->name('resturants.sortChoosen.store');

        Route::get('resturants/sortOffers','ResturantController@sortOffers')->name('resturants.sortOffers');
        Route::post('resturants/sortOffers','ResturantController@sortOffersSubmit')->name('resturants.sortOffers.store');

        Route::resource('resturants', 'ResturantController');
        Route::name('resturants.')->prefix('/resturants/{resturant}')->group(function(){
            Route::resource('branches', 'BranchController');
        });
        Route::name('branches.')->prefix('/branches/{branch}')->group(function(){
            Route::resource('tables', 'TableController');
            Route::get('tables/{table}/qrCode','TableController@qrCode')->name('tables.qrCode');
        });
        //Terms
        Route::get('/terms', 'SiteConfigController@create')->name('terms.view');
        Route::post('/terms', 'SiteConfigController@store')->name('terms.store');
        Route::resource('resturantOwners', 'ResturantOwnerController');

        //Products
        Route::get('resurant/{resturant}/items','ItemController@index')->name('resturants.items.index');
        Route::get('resurant/{selectedResturant}/items/create','ItemController@create')->name('resturants.items.create');
        Route::resource('items', 'ItemController');
        Route::get('item/{item}/sizes','SizeController@index')->name('items.sizes.index');
        Route::get('items/{item}/create','SizeController@create')->name('items.createForProduct');
        Route::group(['prefix'=>'items/{item}/'],function (){
            Route::resource('sizes', 'SizeController');
            Route::resource('sides','ItemSideController');
        });

        Route::group(['prefix'=>'resturant/{resturant}/'],function (){
            Route::resource('lists', 'ListController');
        });

        //orders
        Route::get('orders/{order}/getOrderDetails','OrderController@getOrderDetailsAjax')->name('orders.ajax.getOrderDetails');
        Route::get('orders/getOrdersView','OrderController@getOrdersViewsAjax')->name('orders.ajax.getOrdersRows');
        Route::get('orders/getOrdersModals','OrderController@getOrdersModalsAjax')->name('orders.ajax.getOrdersModals');
        Route::post('orders/index','OrderController@ordersIndex')->name('orders.indexPage');
        Route::post('orders/{order}/changeStatus','OrderController@changeOrderStatusAjax')->name('orders.ajax.changeOrderStatus');
        Route::resource('orders', 'OrderController');
        Route::resource('notifications', 'NotificationsController');

        //ProductSubCategories
//        Route::get('resturant/{resturant}/itemCategories', 'ResturantItemCategoryController@index')->name('resturants.itemCategories.index');
//        Route::get('resturantItemCategories/{selectedResturant}/create', 'ResturantItemCategoryController@create')
//                    ->name('resturants.resturantItemCategories.create');
        Route::group(['prefix'=>'/resturant/{resturant}'],function (){
            Route::resource('itemCategories', 'ResturantItemCategoryController');
        });
        //places
        Route::get('places/{place}', 'PlaceController@get');
        Route::resource('place', 'PlaceController')->except([
            'destroy'
        ]);
        Route::resource('city', 'CityController');
        Route::resource('userFeedbackReason', 'UserFeedbackReasonsController');

        //feedbacks
        Route::resource('feedbacks', 'UserFeedbackController');

        Route::group(['prefix' => 'reports'], function () {
            //Users
            Route::get('users','ReportsController@usersReport')->name('reports.users');
            Route::get('users/getUsersData','ReportsController@getUsersData')->name('reports.users.getUsersData');
            Route::get('orders','ReportsController@ordersReport')->name('reports.orders');
            Route::post('orders/getOrdersData','ReportsController@getOrdersData')->name('reports.orders.getOrdersData');

            Route::get('visits','ReportsController@visitsReport')->name('reports.visits');
            Route::get('visits/getVisitsData','ReportsController@getVisitsData')->name('reports.visits.getVisitsData');
        });

        Route::get('employeeRoles','RoleController@index')->name('employee.roles.index');
        Route::get('employeeRoles/create','RoleController@create')->name('employee.roles.create');
        Route::post('employeeRoles/store','RoleController@store')->name('employee.roles.store');
        Route::get('employeeRoles/{role}/edit','RoleController@edit')->name('employee.roles.edit');
        Route::put('employeeRoles/{role}/update','RoleController@update')->name('employee.roles.update');
        Route::delete('employeeRoles/{role}','RoleController@destroy')->name('employee.roles.destroy');
        Route::resource('employee', 'EmployeeController');
        Route::resource('waiter', 'WaiterController');

    });
});


// Route::get('resturants/categories', 'ResturantController@getCategories')->name('ajax.getCategories');




// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function () {
    return view('test');
});
