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

// Route::get('/', 'AngularController@serveApp');

// Route::get('/unsupported-browser', 'AngularController@unsupported');


Route::get('/', 'AngularController@serveApp')->name('main.home');

Route::get('/', function() {
    if (Route::has('voyager.login')) {
        return redirect()->route('voyager.login');
    }

    return redirect()->route('main.home');
});

Route::get('/unsupported-browser', 'AngularController@unsupported');
