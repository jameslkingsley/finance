<?php

// Core
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/', 'HomeController@index')->name('home');

// User Settings
Route::get('/settings', 'SettingsController@index');

// Funds
Route::get('/api/user/funds', 'API\FundController@index');
Route::post('/api/user/funds', 'API\FundController@store');

// Savings
Route::get('/api/user/savings', 'API\SavingsController@index');
Route::post('/api/user/savings', 'API\SavingsController@store');

// Income
Route::post('/api/user/income', 'API\IncomeController@store');

// Weeks
Route::get('/api/weeks/{week}', 'WeekController@show');
Route::post('/api/weeks', 'WeekController@store');

// Summary, Goal & Savings
Route::get('/api/summary', 'SummaryController@index');
Route::put('/api/goal', 'GoalController@update');
Route::put('/api/savings', 'SavingsController@update');

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

// User
Route::put('/api/user', 'UserBornController@update');
