<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', ['uses' => 'HomeController@index', 'as' => 'index']);
    Route::get('accounts/', ['uses' => 'AccountsController@index', 'as' => 'accounts']);
    Route::get('accounts/create', ['uses' => 'AccountsController@create', 'as' => 'accounts.create']);
    Route::post('accounts/create', ['uses' => 'AccountsController@store', 'as' => 'accounts.store']);
    Route::get('accounts/view/{id}', ['uses' => 'AccountsController@view', 'as' => 'accounts.view']);
    Route::get('accounts/view/{id}/transaction', [
        'uses' => 'AccountsController@transaction',
        'as' => 'accounts.transaction'
    ]);
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
});
