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


Route::prefix('admin')->group(function() {
        
    Route::get('/', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::get('login', 'App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'App\Http\Controllers\Auth\LoginController@login')->name('login_verify');;


    Route::middleware('auth')->group(function() {

        Route::get('dashboard', 'App\Http\Controllers\Admin\DashboardController@index')->name('dashboard');
        Route::post('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
        
        Route::resource('product', 'App\Http\Controllers\Admin\ProductController');
        Route::resource('portfolio', 'App\Http\Controllers\Admin\PortfolioController');
        Route::resource('news', 'App\Http\Controllers\Admin\NewsController');
        Route::resource('team', 'App\Http\Controllers\Admin\TeamController');
        Route::resource('page', 'App\Http\Controllers\Admin\PageController');
        Route::resource('brand', 'App\Http\Controllers\Admin\BrandController');
        
        // Route::resource('transaction', 'App\Http\Controllers\Admin\TransactionController');


        // Route::resource('warehouse', 'App\Http\Controllers\Admin\WarehouseController');
        Route::resource('user', 'App\Http\Controllers\Admin\UserController');
        Route::get('/log', 'App\Http\Controllers\Admin\LogController@index')->name('log');
        

        
        Route::post('/shortcut-publish', 'App\Http\Controllers\Admin\SettingController@publish')->name('publish');
        Route::get('/export', 'App\Http\Controllers\Admin\SettingController@export')->name('export');

        
        Route::get('/sales', 'App\Http\Controllers\Admin\SalesController@index')->name('sales');
    });
});



Route::get('/', 'App\Http\Controllers\HomeController@index')->name('fe_home');
Route::get('/products/{slug}', 'App\Http\Controllers\PageController@productInner')->name('fe_product_inner');
Route::get('/services/{slug}', 'App\Http\Controllers\PageController@serviceInner')->name('fe_service_inner');
Route::get('/news-and-awards/{slug}', 'App\Http\Controllers\PageController@newsInner')->name('fe_news_inner');
Route::get('/portfolio/{slug}', 'App\Http\Controllers\PageController@portfolioInner')->name('fe_portfolio_inner');
Route::get('/{slug}', 'App\Http\Controllers\PageController@page')->name('fe_page');


Route::post('/contact-us-now', 'App\Http\Controllers\HomeController@contact_us_now')->name('fe_contact_us');