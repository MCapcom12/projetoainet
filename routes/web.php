<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });


// dashboard
Route::get('admin', 'DashboardController@index')->name('admin.dashboard');
Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

//conta
Route::get('admin/contas','ContaController@admin')->name('admin.contas');
Route::get('contas','ContaController@index')->name('disciplinas.index');