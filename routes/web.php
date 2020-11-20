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

Route::get('/home', function(){
    return view('home');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

//Auth::routes();

Route::get('/', [
    'as'    => 'index',
    'uses'  => 'HomeController@index'
]);

Route::get('gallery',[
    'as' => 'portfolio',
    'uses' => 'PortfolioController@index']);

Route::get('informations/{category?}', [
        'as' => 'category',
        'uses' => 'ArticlesController@index'
])->where('category','[\w-]+');

Route::get('stock/', 'StockController@index')->name('stocks');
Route::get('stock/{stock}', [
    'as' => 'stock',
    'uses' => 'StockController@show'
])->where('stock','[\w-]+');

Route::get('services/', 'ServicesController@index')->name('services');
Route::get('services/{service}', [
    'as' => 'service',
    'uses' => 'ServicesController@show'
])->where('service','[\w-]+');

Route::get('announce/{announce}', [
    'as' => 'announce',
    'uses' => 'AnnouncementController@show'
])->where('announce','[\w-]+');

Route::post('service-form', 'ServicesController@store');
Route::post('page-form', 'PageController@store');
Route::post('detail-form', 'ServicesController@detailForm')->name('detailForm');

Route::get('page/{page}', 'PageController@page')->name('page');

Route::group(['middleware' => ['auth','admin'], 'prefix' => 'admin'], function(){
    Route::get('/', ['uses' => 'Admin\IndexController@index']);
    Route::resource('/informations', 'Admin\ArticlesController');
    Route::resource('/services', 'Admin\ServicesController');
    Route::resource('/accordion', 'Admin\AccordionController');
    Route::resource('/category', 'Admin\CategoryController');
    Route::resource('/gallery', 'Admin\PortfolioController');
    Route::resource('/page', 'Admin\PageController');
    Route::post('/update_file/{id}', 'Admin\PortfolioController@updateFileByID')->name('update_file');
    Route::post('/delete_selected', 'Admin\PortfolioController@delSelectedImages')->name('delete_selected');
    Route::resource('/menu', 'Admin\MenuController');
    Route::resource('/stock', 'Admin\StockController');
    Route::resource('/announce', 'Admin\AnnouncementController');
    Route::resource('/author', 'Admin\AuthorController');
});

