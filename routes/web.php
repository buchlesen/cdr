<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'AngularController@serveApp')->name('main.home');

Route::get('/', function() {
    if (Route::has('voyager.login')) {
        return redirect()->route('voyager.login');
    }

    return redirect()->route('main.home');
});

Route::get('/unsupported-browser', 'AngularController@unsupported');

