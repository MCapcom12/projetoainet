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
Route::get('/', 'DashboardController@index')->name('dashboard');
Auth::routes(['verify' => true]);
Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

//conta
Route::get('contas','ContaController@admin')->name('contas');


Route::get('contas/{id}/edit','ContaController@edit')->name('contas.edit');
Route::get('contas/create','ContaController@create')->name('contas.create');

Route::post('admin/contas/create','ContaController@store')->name('contas.store');

//users
Route::get('users','UserController@index')->name('users');

//Movimentos
Route::get('Movimentos', 'MovimentoController@index')->name('Movimentos');

