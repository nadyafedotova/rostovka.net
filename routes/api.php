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

Route::post('/upd', 'ProductController@updateFilters');

Route::post('/test', 'Admin\CSV\CsvDownloadController@testPost');

Route::post('/testProducts', 'ProductController@getProductsToCategoryTest');
Route::post('/checkData', function (Request $request){

    ///dd( $request -> all() );
    return $request -> all();

});


// Route::post('/product', 'ProductController@getProduct');

Route::post('/getSizesMass', 'ProductController@getSizesMass');
//Route::post('/getMaxSize', 'ProductController@getMaxSize');

Route::post('/testTopSales','SaleController@testTopSales');
Route::post('/pagination', 'ProductController@getPaginationPageCount');


Route::post('/generateDateCash', 'SaleController@generateDateCash');

//Route::post('');

//Route::get('/csvDownloadOrdersToSend','Admin\CSV\CsvOrderController@getCsvFileWithOrdersToSend');
//Route::get('/csvDownloadOrdersToManufacturer','Admin\CSV\CsvDownloadController@getCsvFileWithOrdersToManufacturer');
//Route::get('/csvDownload','Admin\CSV\CsvDownloadController@getCsvFileWithProduct') -> name('download');
//Route::get('/csvDownloadOrders','Admin\CSV\CsvOrderController@getCsvFileWithOrders') -> name('downloadOrder');
//Route::post('/csvDownloadOrders','Admin\CSV\CsvOrderController@getCsvFileWithOrders');
//Route::post('/csvDownloadOrdersImages','Admin\CSV\CsvOrderController@getCsvFileWithOrdersImages');

