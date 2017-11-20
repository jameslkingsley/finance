<?php

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/api/weeks/{week}', 'WeekController@show');
Route::post('/api/weeks', 'WeekController@store');

Route::get('/api/summary', 'SummaryController@index');

Route::put('/api/goal', 'GoalController@update');

Route::get('/api/analysis', 'AnalysisController@index');

Route::get('/api/expenses', 'ExpensesController@index');
Route::post('/api/expenses', 'ExpensesController@store');
Route::delete('/api/expenses/{expense}', 'ExpensesController@destroy');
