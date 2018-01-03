<?php

use Illuminate\Http\Request;

Route::get('/test', function (Request $request)
{
    return "test";
});

Route::get('/register', 'Auth\ApiAuthController@register');

Route::post('/register', 'Auth\ApiAuthController@register');

Route::get('/login', 'Auth\ApiAuthController@login');

Route::post('/login', 'Auth\ApiAuthController@login');

Route::get('/behave', 'Auth\ApiAuthController@behave');

Route::post('/behave', 'Auth\ApiAuthController@behave');
