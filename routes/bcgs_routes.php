<?php

use Illuminate\Http\Request;

/*
Route::get('/register', function (Request $request)
{
    return "bcgs register";
});
*/
Route::get('/register', 'Auth\ApiRegisterController@create');

Route::post('/register', 'Auth\ApiRegisterController@create');
