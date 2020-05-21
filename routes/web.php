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
Route::get('contas','ContaController@admin')->name('contas')->middleware('auth');

Route::get('contas/{conta}/detalhe','ContaController@detalhe')->name('contas.detalhe');
Route::get('contas/{conta}/edit','ContaController@edit')->name('contas.edit');
Route::get('contas/create','ContaController@create')->name('contas.create');

Route::post('contas/create','ContaController@store')->name('contas.store');

//users
Route::get('users','UserController@index')->name('users')->middleware('auth');
Route::get('/search', 'UserController@search');

//Movimentos
Route::get('Movimentos', 'MovimentoController@index')->name('Movimentos')->middleware('auth');

//Perfil
Route::get('Perfil', 'PerfilController@index')->name('Perfil')->middleware('auth');
Route::get('Perfil/Edit', 'ProfilesController@index')->name('Edit')->middleware('auth');
Route::post('Perfil/Edit', 'ProfilesController@update')->name('Update');
Route::get('Perfil/ChangePassword/', 'ChangePasswordController@index');
Route::post('Perfil/ChangePassword/', 'ChangePasswordController@store')->name('ChangePassword');
Route::post('Perfil/Delete', 'ProfilesController@deleteUser')->name('deleteUser');