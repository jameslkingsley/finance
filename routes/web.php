<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/api/weeks/{week}', 'WeekController@show');
Route::post('/api/weeks', 'WeekController@store');
