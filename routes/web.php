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


// Route::get('/about', function (){

//     return view('user.about');

// });

Route::get('/about', 'AboutController@index');

Route::get('/parsing', 'Parsing\ParsingController@index');

//////////////////////////////////////////////////////////////////////////////
Route::get('/', 'HomeController@index')->name('root');



Route::get('/login', 'HomeController@login') -> name("login");
Route::post('/login', 'HomeController@auth');



Route::get('/tov',  function (){

    return view('admin.product.tov');

});

Route::get('/register', 'HomeController@registerIndex');
Route::post('/register', 'HomeController@register') -> name('register');

//===================================================================================
Route::get('{id}/category','CategoryController@show');
Route::get('{id}/product/{number?}', 'ProductController@show');
//===================================================================================

Route::get('/checkout', function () {
    return view('user.billing.checkout');
});

// Route::get('/test/checkout', function () {
//     return view('user.billing.checkout1');
// });

Route::post('/checkout', 'SaleController@makeOrder');

Route::get('/testTopSales','SaleController@testTopSales');

Route::get('/cart', function () {
    return view('user.cart.cart');
})->name('cart');


Route::post('orderCash', 'SaleController@getOrderCash');



Route::get('showOrderManufacturer/{orderCash}', 'SaleController@showOrderManufacturer');

//Route::get('/product_add', function () {
//    return view('admin.product.pdoructadd');
//});

Route::get('showFinderFinal/{name}', "ProductController@filterProduct");
Route::get('styles/showFinderFinal/{name}', "ProductController@stylesFilterProduct");


Route::get('/pdfLoad/{id}', 'Admin\PDF\ReceiptController@index');
Route::get('/pdfShow', 'Admin\PDF\ReceiptController@show');

Route::group(['middleware' => 'web'], function () {
	Route::get('password/reset', 'Auth\PasswordController@showResetForm');
	Route::post('recovery/', 'Auth\PasswordController@sendEmailConfirm');
    Route::get('recovery/{token}', 'Auth\PasswordController@sendEmailConfirm');
    Route::post('password/update', 'Auth\PasswordController@updatePass');
});

Route::group(['middleware' => 'auth'], function () {

    Route::group(['middleware' => 'moder'], function () {

        Route::get('/suppliers/{name?}', 'Admin\SuppliersController@index')->name('suppliers');
        Route::get('/suppliers_edit/{id}', 'Admin\SuppliersController@edit');
        Route::post('/suppliers_update', 'Admin\SuppliersController@update');
        Route::get('/suppliers_delete/{id}', 'Admin\SuppliersController@delete');

        Route::group(['middleware' => 'admin'], function () {
            Route::get('/admin_index/{name?}', 'Admin\HomeController@index')->name("adminIndex");
            Route::get('/user_edit/{id}', 'Admin\HomeController@editClient');
            Route::post('/user_delete/{id}', 'Admin\HomeController@deleteClient');
            Route::post('/user_update', 'Admin\HomeController@updateClient');
            Route::post('/delsale', 'Admin\HomeController@deleteSale');
            Route::post('/delman', 'Admin\BrandsController@deleteMan');
        });

        Route::post('/finder','Admin\ProductController@finder');//пои сковик товаров по имени

        Route::group(['middleware' => 'admin'], function () {

            Route::get('/admin/testMans','ProductController@testMans') -> name (' admNovIndex ');

            Route::get('/admin/novelty','Admin\NoveltyController@index') -> name (' admNovIndex ');
            Route::delete('/admin/novelty', 'Admin\NoveltyController@delete')->name('adminDelNov');

            Route::get('/fools', 'Admin\FoolController@index')->name('adminFool');

            Route::get('/fools', 'Admin\FoolController@index')->name('adminFool');
            Route::post('/fools', 'Admin\FoolController@addFools')->name('adminAddFool');
            Route::post('/fools/add', 'Admin\FoolController@add2Fools')->name('adminAdd2Fool');
            Route::delete('/fools', 'Admin\FoolController@delFools')->name('adminDelFool');

            Route::get('/admin/about', 'Admin\AboutController@index')->name('adminAbout');
            Route::post('/admin/about', 'Admin\AboutController@update')->name('adminUpdAbout');

            Route::get('/colors', 'Admin\ProductController@colors');

        	Route::get('/styles','CategoryController@showByName2') -> name (' catByName2 ');
            Route::get('/orders/{name?}', 'Admin\OrderController@index')->name('orders');
            Route::get('/seo', 'Admin\SeoController@index')->name('adminSeo');
            Route::get('/top', 'Admin\TopController@index')->name('adminTop');
            Route::post('/top', 'Admin\TopController@addToTop')->name('adminToTop');
            Route::delete('/top', 'Admin\TopController@delTop')->name('adminDelTop');

            Route::get('/admin/brands', 'Admin\BrandsController@index')->name('adminBrands');
            Route::get('/admin/brand/{name}', 'Admin\BrandsController@editing')->name('adminEdBrands');
            Route::post('/admin/brand', 'Admin\BrandsController@update')->name('adminUpdBrands');
            Route::delete('/admin/brand', 'Admin\BrandsController@delete')->name('adminDelBrands');

            Route::get('/testExcel', 'Admin\CSV\CsvLoadController@reloadCsvShoesLoad')->name('adminExcel');
            Route::get('/seo/{id}', 'Admin\SeoController@editing');
            Route::post('/seo_update', 'Admin\SeoController@update');
            Route::get('/orderInfo/{id}', 'Admin\OrderController@orderInfo');
            Route::post('/deleteProductFromOrder','Admin\OrderController@deleteOrderDetail');//удаление товара из заказа передавать id из orderdetails
            Route::post('/deleteOrder','Admin\OrderController@deleteOrder');//удаление всего заказа передавать id заказа
            Route::post('/addOrderDetail','Admin\OrderController@addOrderDetail');// добавление товара(ов) в заказ, передавать: id заказа массив id товаров, колличества товаров
            Route::post('/orderUpdate', 'Admin\OrderController@update');
        });

        Route::get('/products/{name?}', 'Admin\ProductController@index') ->name('products');//вывод списка всех товаров
        Route::get('/product', 'ProductController@create');
        Route::post('/product','ProductController@add');
        Route::post('/product/delete','Admin\ProductController@delete'); // удаление товара - передавать id товара
        Route::post('/product/update','Admin\ProductController@update'); // редактирование товара - передавать id товара и массив редактирование (с/без фото)
        Route::get('/product/{id}/edit','Admin\ProductController@edit'); // редактирование товара - ссылка на страницу редактирование
        Route::post('/testIncomeData', 'Admin\ProductController@tovarMultiUpdate');// на эту ссылку ид>т запрос при мульти редактировании

        Route::get('/csvGlovesLoad','Admin\CSV\CsvGloversLoadController@index');
        Route::post('/csvGlovesLoad','Admin\CSV\CsvGloversLoadController@csvGloversLoad') -> name('load_gloves');

        Route::get('/csvGlovesUpdate','Admin\CSV\CsvGloversLoadController@edit');
        Route::post('/csvGlovesUpdate','Admin\CSV\CsvGloversLoadController@csvGloversUpdate') -> name('update_gloves');

        Route::post('/csvGlovesDelete','Admin\CSV\CsvGloversLoadController@csvGloversDelete') -> name('delete_gloves');


        Route::get('/csvLoad','Admin\CSV\CsvLoadController@index');
        Route::post('/csvLoad','Admin\CSV\CsvLoadController@csvShoesLoad') -> name('load');

        //Route::get('/csvLoadUpdate','Admin\CSV\CsvLoadController@edit');
        Route::post('/csvLoadUpdate','Admin\CSV\CsvLoadController@csvShoesUpdate') -> name('update');

        Route::post('/csvLoadUpdatePhoto','Admin\CSV\CsvLoadController@onlyPhotoUpdate') -> name('updatePhoto');// ссылка для обновления только урлов фоток
        Route::get('/csvLoadUpdatePhoto','ParchomController@index');

        Route::post('/csvLoadDelete','Admin\CSV\CsvLoadController@csvShoesDelete') -> name('delete');

        //Route::post('/csvDownload','Admin\CSV\CsvDownloadController@getCsvFileWithProduct') -> name('download');


        /////////////////////////Page orders///////////////////////////////
        Route::get('/csvDownloadOrders','Admin\CSV\CsvOrderController@getCsvFileWithOrders')-> name('downloadOrder'); // для производителя без фоткой //передать дату с и доту по. Возвращает xlsx файл.
        Route::get('/csvDownloadOrdersImages','Admin\CSV\CsvOrderController@getCsvFileWithOrdersImages')-> name('downloadOrderWithImages');// для производителя с фоткой передать дату с и доту по. Возвращает xlsx файл.
        Route::get('/csvDownloadOrdersToSend','Admin\CSV\CsvOrderController@getCsvFileWithOrdersToSend')-> name('downloadOrderToSend');
        Route::get('/csvDownloadOrdersPDF','Admin\CSV\CsvOrderController@getCsvFileWithOrdersPDF')-> name('downloadOrderPDF'); // для производителя без фоткой //передать дату с и доту по. Возвращает xlsx файл.
        Route::get('/csvDownloadOrdersImagesPDF','Admin\CSV\CsvOrderController@getCsvFileWithOrdersImagesPDF')-> name('downloadOrderWithImagesPDF');// для производителя с фоткой передать дату с и доту по. Возвращает xlsx файл.
        Route::get('/csvDownloadOrdersToSendPDF','Admin\CSV\CsvOrderController@getCsvFileWithOrdersToSendPDF')-> name('downloadOrderToSendPDF');
        ////////////////////////////////////////////////////////////////////////


        //////////////////////Page products////////////////////////////
        Route::get('/testDownload','Admin\CSV\CsvDownloadController@testDownload')-> name('testDownload');
        Route::get('/testDownloadPDF','Admin\CSV\CsvDownloadController@testDownloadPDF')-> name('testDownloadPDF');

        Route::get('/fullDownloadPDF','Admin\CSV\CsvDownloadController@fullDownloadPDF')-> name('fullDownloadPDF');

        Route::get('/csvDownloadOrdersToManufacturer','Admin\CSV\CsvDownloadController@getCsvFileWithOrdersToManufacturer')-> name('downloadProductToManufacturer');
        Route::get('/csvDownloadOrdersToManufacturerOhnePhoto','Admin\CSV\CsvDownloadController@getCsvFileWithOrdersToManufacturerOhnePhoto')-> name('downloadProductToManufacturerOhnePhoto');
        Route::get('/csvDownload','Admin\CSV\CsvDownloadController@getCsvFileWithProduct') -> name('download');

        Route::get('/csvDownloadOrdersToManufacturerPDF','Admin\CSV\CsvDownloadController@getCsvFileWithOrdersToManufacturerPDF')-> name('downloadProductToManufacturerPDF');
        Route::get('/csvDownloadOrdersToManufacturerOhnePhotoPDF','Admin\CSV\CsvDownloadController@getCsvFileWithOrdersToManufacturerOhnePhotoPDF')-> name('downloadProductToManufacturerOhnePhotoPDF');
        ////////////////////////////////////////////////////////////////

        Route::get('/personal', 'Admin\HomeController@personal');
        Route::post('/personal/update', 'Admin\HomeController@personalUpdate');

        Route::get('/type', 'Admin\TypeController@index') ->name('types');
        Route::get('/type/{id}', 'Admin\TypeController@editing');
        Route::post('/type', 'Admin\TypeController@update')->name('typeUpd');
        Route::delete('/type/{id}', 'Admin\TypeController@delete');

        Route::get('/seasonRemove/{id}', 'Admin\TypeController@deleteSeason');


        Route::post('/generateDateCash', 'SaleController@generateDateCash');
        Route::get('showOrder/{orderCash}', 'SaleController@showOrderOnCash');

    });


    Route::post('/logout', 'HomeController@logout');

    Route::get('/userinfo', 'ClientController@index');
    Route::post('/userUpdate', "ClientController@update");




});

Route::get('sitemap','SitemapController@index');

Route::get('/novelty','NoveltyController@index') -> name (' novIndex ');
Route::get('/novelty/{id}','NoveltyController@specific') -> name (' novSpec ');

Route::get('/brands', 'BrandsController@index')->name('brands');
Route::get('/brand/{name}', 'BrandsController@getBrandProducts')->name('brands');

Route::get('/styles/{name}','CategoryController@showByName2') -> name (' catByNameStyles ');
Route::get('/styles/{name}/{pname}/{number?}', 'ProductController@showByNameWithSlider') -> name ( 'sliderProdByName' );

Route::post('/api/product', 'ProductController@getProduct');
Route::post('/api/checkCard', 'ProductController@checkCardProducts');
Route::post('/api/products', 'ProductController@getProductsToCategory');
Route::post('/api/news', 'ProductController@getNewsProduct');
Route::post('/api/topSales','SaleController@getTopSales');

// Route::get('/api/productsTest', 'ProductController@getProductsToCategoryTest');

Route::get('/{link}/types/{post}', 'ProductController@showByFilter');
Route::get('/{name}', 'CategoryController@showByName') -> name (' catByName ');
Route::get('/{name}/{pname}/{number?}', 'ProductController@check') -> name ( 'prodByName' );
