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

Route::put('contas/{conta}/detalhe','ContaController@update')->name('contas.update');
Route::delete('contas/{conta}/detalhe','ContaController@destroy')->name('contas.destroy');


Route::get('contas/{conta}/auth','ContaController@auth')->name('contas.auth');
Route::get('contas/{conta}/addUser', 'ContaController@addUser')->name('contas.addUser');
Route::get('contas/{conta}/removeUser/{id}', 'ContaController@removeUser')->name('contas.removeUser');
Route::get('contasPartilhadas', 'ContaController@contasPartilhadas')->name('contasPartilhadas')->middleware('auth');
Route::get('contas/{conta}/changeAuth/{id}', 'ContaController@changeAuth')->name('contas.changeAuth');

//vai buscar as contas eliminadas de um determinado user
Route::get('contas/lixeira','ContaController@lixeira')->name('contas.lixeira');
Route::post('contas/{id}/restore','ContaController@restore')->name('contas.restore');
Route::post('contas/{id}/forceDelete','ContaController@forceDelete')->name('contas.forceDelete');


//users
Route::get('users','UserController@index')->name('users')->middleware('auth');
Route::get('/search', 'UserController@search');
Route::get('users/{user}/changeType','UserController@adminChangeType')->name('changeType');
Route::get('users/{user}/changeBlock','UserController@adminChangeBlock')->name('changeBlock');
Route::get('users/{user}/auth','UserController@authConta')->name('authConta');
Route::get('users/{user}/authUser/{conta}','UserController@authUser')->name('authUser');


//Movimentos
//Route::get('movimentos', 'MovimentoController@index')->name('movimentos')->middleware('auth');
Route::get('contas/{conta}/movimentos/create', 'MovimentoController@create')->name('movimentos.create');
Route::post('contas/{conta}/movimentos/create', 'MovimentoController@store')->name('movimentos.store');
Route::get('movimentos/{movimento}/edit', 'MovimentoController@edit')->name('movimentos.edit');
Route::put('movimentos/{movimento}','MovimentoController@update')->name('movimentos.update');
Route::delete('movimentos/{movimento}','MovimentoController@destroy')->name('movimentos.destroy');
//Route::get('categorias', 'MovimentoController@all_categorias')->name('categorias');
//Route::get('contas/{conta}/movimentos/{movimento}');
//Route::get('movimentos/{movimento}/edit');
//Route::get('movimentos/{movimento}');

//Perfil
Route::get('Perfil', 'PerfilController@index')->name('Perfil')->middleware('auth');
Route::get('Perfil/Edit', 'ProfilesController@index')->name('Edit')->middleware('auth');
Route::post('Perfil/Edit', 'ProfilesController@update')->name('Update');
Route::get('Perfil/ChangePassword/', 'ChangePasswordController@index');
Route::post('Perfil/ChangePassword/', 'ChangePasswordController@store')->name('ChangePassword');
Route::post('Perfil/Delete', 'ProfilesController@deleteUser')->name('deleteUser');


//Estatisticas

Route::get('Estatisticas','EstatisticaController@index')->name('estatistica')->middleware('auth');