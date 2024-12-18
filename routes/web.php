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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/categories', 'CategoryController@index')->name('categories');
Route::get('/categories/{id}', 'CategoryController@detail')->name('categories-detail');

Route::get('/detail/{id?}', 'DetailController@index')->name('detail');
Route::post('/detail/{id?}', 'DetailController@add')->name('detail-add');


Route::post('/checkout/callback', 'CheckoutController@callback')->name('midtrans-callback');
Route::get('/succes', 'CartController@succes')->name('succes');

Route::get('/register/succes', 'Auth\RegisterController@succes')->name('register-succes');


route::group(['middleware' => ['auth']], function () {
    Route::get('/cart', 'CartController@index')->name('cart');
    Route::delete('/cart/{id}', 'CartController@Delete')->name('cart-delete');
    Route::post('/cart/update-quantity', 'CartController@updateQuantity')->name('cart.update-quantity');

    Route::post('/checkout', 'CheckoutController@process')->name('checkout');




    Route::get('/dashboard/history', 'DashboardHistoryController@index')->name('dashboard-history');
    Route::get('/dashboard/history/{id}', 'DashboardHistoryController@detail')->name('dashboard-history-detail');

    Route::get('/dashboard/setting', 'DashboardSettingController@setting')->name('dashboard-setting');
    Route::get('/dashboard/account', 'DashboardSettingController@account')->name('dashboard-account');
    Route::post('/dashboard/account/{redirect}', 'DashboardSettingController@update')->name('dashboard-account-redirect');
});

//->middleware(['auth', 'admin'])
Route::prefix('admin')->namespace('Admin')->middleware(['auth', 'admin'])->group(function () {
    route::get('/', 'DashboardController@index')->name('admin-dashboard');
    route::resource('category', 'CategoryController');
    route::resource('user', 'UserController');
    route::resource('product', 'ProductController');
    route::resource('product-gallery', 'ProductGalleryController');
});

Route::prefix('cs')->middleware(['auth', 'cs'])->group(function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/dashboard/product', 'DashboardProductController@index')->name('dashboard-product');
    Route::get('/dashboard/product/create', 'DashboardProductController@create')->name('dashboard-product-create');
    Route::post('/dashboard/product', 'DashboardProductController@store')->name('dashboard-product-store');
    Route::get('/dashboard/product/{id}', 'DashboardProductController@detail')->name('dashboard-product-detail');
    Route::post('/dashboard/product/{id}', 'DashboardProductController@update')->name('dashboard-product-update');

    Route::post('/dashboard/product/gallery/upload', 'DashboardProductController@uploadGallery')->name('dashboard-product-gallery-upload');
    Route::get('/dashboard/product/gallery/delete/{id}', 'DashboardProductController@deleteGallery')->name('dashboard-product-gallery-delete');

    Route::get('/dashboard/transaction', 'DashboardTransactionController@index')->name('dashboard-transaction');
    Route::get('/dashboard/transaction/{id}', 'DashboardTransactionController@detail')->name('dashboard-transaction-detail');
    Route::post('/dashboard/transaction/{id}', 'DashboardTransactionController@update')->name('dashboard-transaction-update');
});



Auth::routes();
