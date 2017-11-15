<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/api/weeks/{week}', 'WeekController@show');
Route::post('/api/weeks', 'WeekController@store');

Route::get('/api/summary', 'SummaryController@index');

Route::put('/api/goal', 'GoalController@update');
