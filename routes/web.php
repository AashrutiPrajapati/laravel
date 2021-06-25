<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'App\Http\Controllers\DashboardController@index');
// Route::get('dashboard', 'App\Http\Controllers\DashboardController@index');

Route::get('customer', 'App\Http\Controllers\CustomerController@index');
Route::get('customers/page={number}', 'App\Http\Controllers\CustomerController@index');
Route::get('customers/create', 'App\Http\Controllers\CustomerController@create');
Route::post('customers/store', 'App\Http\Controllers\CustomerController@store');
Route::get('customers/edit/{id}', 'App\Http\Controllers\CustomerController@edit');
Route::get('customers/status/{id}', 'App\Http\Controllers\CustomerController@status');
Route::post('customers/update/{id}', 'App\Http\Controllers\CustomerController@update');
Route::get('customers/destroy/{id}', 'App\Http\Controllers\CustomerController@destroy');
Route::get('customers/address/{id}', 'App\Http\Controllers\CustomerController@address');
Route::post('customers/saveAddress/{id}', 'App\Http\Controllers\CustomerController@saveAddress');

Route::get('product', 'App\Http\Controllers\ProductController@index');
Route::get('products/page={number}', 'App\Http\Controllers\ProductController@index');
Route::get('products/create', 'App\Http\Controllers\ProductController@create');
Route::post('products/store', 'App\Http\Controllers\ProductController@store');
Route::get('products/edit/{id}', 'App\Http\Controllers\ProductController@edit');
Route::get('products/status/{id}', 'App\Http\Controllers\ProductController@status');
Route::post('products/update/{id}', 'App\Http\Controllers\ProductController@update');
Route::get('products/destroy/{id}', 'App\Http\Controllers\ProductController@destroy');
Route::get('products/media/{id}', 'App\Http\Controllers\ProductController@media');
Route::post('products/mediaSave/{id}', 'App\Http\Controllers\ProductController@mediaSave');
Route::post('products/mediaUpdate/{id}', 'App\Http\Controllers\ProductController@mediaUpdate');

Route::get('category', 'App\Http\Controllers\CategoryController@manageCategory');
Route::post('category/addCategory', 'App\Http\Controllers\CategoryController@addCategory');
Route::post('category/addSubCategory', 'App\Http\Controllers\CategoryController@addSubCategory');
Route::get('category/create', 'App\Http\Controllers\CategoryController@create');
Route::post('category/destroy/{id}', 'App\Http\Controllers\CategoryController@destroy');
Route::get('category/edit/{id}', 'App\Http\Controllers\CategoryController@edit');
Route::post('category/update/{id}', 'App\Http\Controllers\CategoryController@update');

Route::get('cart', 'App\Http\Controllers\CartController@index');
Route::get('cart/selectcustomer', 'App\Http\Controllers\CartController@selectcustomer');
Route::post('cart/add_product', 'App\Http\Controllers\CartController@addProductToCart');
Route::post('cart/updateQuantity', 'App\Http\Controllers\CartController@updateQuantity');
Route::get('cart/clearCart', 'App\Http\Controllers\CartController@clearCart');
Route::post('cart/billingAddress', 'App\Http\Controllers\CartController@billingAddress');
Route::post('cart/shippingAddress', 'App\Http\Controllers\CartController@shippingAddress');
Route::post('cart/payment', 'App\Http\Controllers\CartController@payment');
Route::post('cart/shipping', 'App\Http\Controllers\CartController@shipping');
Route::post('cart/placeOrder', 'App\Http\Controllers\CartController@placeOrder');

Route::get('order', 'App\Http\Controllers\OrderController@index');
Route::get('order/page={number}', 'App\Http\Controllers\OrderController@index');
Route::get('order/show/{id}', 'App\Http\Controllers\OrderController@show');
Route::post('order/comments/{id}', 'App\Http\Controllers\OrderController@comments');

Route::get('payment', 'App\Http\Controllers\PaymentController@index');
Route::get('payments/page={number}', 'App\Http\Controllers\PaymentController@index');
Route::get('payment/create', 'App\Http\Controllers\PaymentController@create');
Route::post('payment/store', 'App\Http\Controllers\PaymentController@store');
Route::get('payment/edit/{id}', 'App\Http\Controllers\PaymentController@edit');
Route::get('payment/status/{id}', 'App\Http\Controllers\PaymentController@status');
Route::post('payment/update/{id}', 'App\Http\Controllers\PaymentController@update');
Route::get('payment/destroy/{id}', 'App\Http\Controllers\PaymentController@destroy');

Route::get('shipping', 'App\Http\Controllers\ShippingController@index');
Route::get('shippings/page={number}', 'App\Http\Controllers\ShippingController@index');
Route::get('shipping/create', 'App\Http\Controllers\ShippingController@create');
Route::get('shipping/status/{id}', 'App\Http\Controllers\ShippingController@status');
Route::post('shipping/store', 'App\Http\Controllers\ShippingController@store');
Route::get('shipping/edit/{id}', 'App\Http\Controllers\ShippingController@edit');
Route::post('shipping/update/{id}', 'App\Http\Controllers\ShippingController@update');
Route::get('shipping/destroy/{id}', 'App\Http\Controllers\ShippingController@destroy');

Route::get('importexport', 'App\Http\Controllers\ImportExportController@index');
Route::post('importexport/import', 'App\Http\Controllers\ImportExportController@import');
Route::get('importexport/insert', 'App\Http\Controllers\ImportExportController@insert');
Route::post('importexport/exportIntoCSV', 'App\Http\Controllers\ImportExportController@exportIntoCSV');

Route::get('fileupload', 'App\Http\Controllers\FileUploadController@index');
Route::post('fileupload/import', 'App\Http\Controllers\FileUploadController@import');
Route::get('fileupload/import', 'App\Http\Controllers\FileUploadController@insert');
Route::post('fileupload/export', 'App\Http\Controllers\FileUploadController@export');

Route::get('teacher', 'App\Http\Controllers\TeacherController@index');


Route::get('student', 'App\Http\Controllers\StudentController@index');

Route::get('salesman', 'App\Http\Controllers\SalesmanController@index');
Route::get('salesman/saleid/{id}', 'App\Http\Controllers\SalesmanController@saleid');
Route::post('salesman/search', 'App\Http\Controllers\SalesmanController@index');
Route::post('salesman/clear', 'App\Http\Controllers\SalesmanController@clear');
Route::post('salesman/create', 'App\Http\Controllers\SalesmanController@create');
Route::post('salesman/product', 'App\Http\Controllers\SalesmanController@product');
Route::post('salesman/update/{id}', 'App\Http\Controllers\SalesmanController@update');
Route::get('salesman/destroy/{id}', 'App\Http\Controllers\SalesmanController@destroy');