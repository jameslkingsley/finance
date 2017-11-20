<?php

// Core
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

// Weeks
Route::get('/api/weeks/{week}', 'WeekController@show');
Route::post('/api/weeks', 'WeekController@store');

// Summary & Goal
Route::get('/api/summary', 'SummaryController@index');
Route::put('/api/goal', 'GoalController@update');

// Analysis
Route::get('/api/analysis', 'AnalysisController@index');

// Expenses
Route::get('/api/expenses', 'ExpensesController@index');
Route::post('/api/expenses', 'ExpensesController@store');
Route::delete('/api/expenses/{expense}', 'ExpensesController@destroy');

// Purchases
Route::get('/api/purchases', 'PurchaseController@index');
Route::post('/api/purchases', 'PurchaseController@store');
Route::delete('/api/purchases/{purchase}', 'PurchaseController@destroy');
