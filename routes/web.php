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

/*Route::get('/', ['as' => 'home', 'uses' => function () {
    return view('home');
}]);*/

// API ROUTES
Route::group(['prefix' => 'service', 'as' => 'service.'], function () {
    Route::post('add-category',     ['as' => 'category.add',    'uses' => 'Api\ServiceController@addCategory']);
    Route::post('update-category',  ['as' => 'category.update', 'uses' => 'Api\ServiceController@updateCategory']);
    Route::post('remove-category',  ['as' => 'category.remove', 'uses' => 'Api\ServiceController@removeCategory']);

    Route::post('add-item',         ['as' => 'item.add',            'uses' => 'Api\ServiceController@addItem']);
    Route::post('update-item',      ['as' => 'item.update',         'uses' => 'Api\ServiceController@updateItem']);
    Route::post('remove-item',      ['as' => 'item.remove',         'uses' => 'Api\ServiceController@removeItem']);
    Route::post('update-item-month',['as' => 'item.month.update',   'uses' => 'Api\ServiceController@updateItemMonth']);
});

// ADMIN ROUTES
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    //Login Routes...
    Route::get('login',     ['as' => 'login',       'uses' => 'Admin\Auth\LoginController@showLoginForm']);
    Route::post('login',    ['as' => 'login.post',  'uses' => 'Admin\Auth\LoginController@login']);
    Route::get('logout',    ['as' => 'logout',      'uses' => 'Admin\Auth\LoginController@logout']);

    Route::get('/',         ['as' => 'dashboard',   'uses' => 'Admin\DashboardController@index']);

    Route::get('/users',        ['as' => 'user.list',      'uses' => 'Admin\UserController@index']);
    Route::get('/users/{id}',   ['as' => 'user.report',    'uses' => 'Admin\UserController@report']);
});

// DEFAULT USER
Auth::routes();

Route::get('/',             ['as' => 'home',        'uses' => 'DashboardController@index']);
Route::get('/dashboard',    ['as' => 'dashboard',   'uses' => 'DashboardController@index']);
Route::get('/profile',      ['as' => 'user.profile',    'uses' => 'UserController@profile']);
Route::post('/profile',     ['as' => 'user.update',     'uses' => 'UserController@update']);