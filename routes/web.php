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

//Route::get('/', 'HomeController@index')->name('home');
Auth::routes();

Route::get('/', 'PageController@home');
Route::post('/accesscode', 'PageController@postAccessCode');
Route::get('/export', 'ExportController@exportOrders');
Route::get('/export2', 'ExportController@lloydExport');
//Route::get('/test', 'PageController@test');

Route::group(['middleware' => ['accesscode']], function(){
    Route::get('/products', 'ProductController@index');
    Route::get('/shirts', 'ProductController@getShirts');
    Route::resource('product', 'ProductController');
    Route::get('product/personaliser/{id}/{gatewaymulti?}', 'ProductController@personaliser');
    Route::get('product/personaliser/epa/{id}', 'ProductController@getExternalPricingAPI');

    Route::get('basket', 'CartController@index');
    Route::post('basket/add/{gatewaymulti?}', 'CartController@add');
    Route::get('basket/destroy', 'CartController@destroy');
    Route::get('basket/redir/{id?}/{gatewaymultiId?}', 'CartController@gatewayRedir');
    Route::get('basket/remove-item/{rowId}', 'CartController@getRemoveItem');
    Route::post('basket/update-qty/{rowId}', 'CartController@postUpdateQty');
    Route::post('basket/post-to-print', 'CartController@postToPrint');
    Route::get('complete', 'CartController@getComplete');
    
    Route::get('/logout', 'PageController@logout');
});
