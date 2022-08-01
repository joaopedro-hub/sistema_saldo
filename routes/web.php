<?php

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

// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;
// Route::middleware(['auth'])->group(function(){
//     Route::get('admin', 'Admin\AdminController@index')->name('admin.home');
//     Route::get('admin/balance','Admin\BalanceController@index')->name('admin.balance');
// });

Route::prefix('admin')->middleware('auth')->group(function (){
    Route::get('/historic', 'Admin\BalanceController@historic')->name('balance.historic');
    Route::get('/transfer', 'Admin\BalanceController@transfer')->name('balance.transfer');
    Route::get('/withdrawn','Admin\BalanceController@withdraw')->name('balance.withdraw');
    Route::get('/deposit', 'Admin\BalanceController@deposit')->name('balance.deposit');
    Route::get('/balance', 'Admin\BalanceController@index')->name('balance');
    Route::get('/', 'Admin\AdminController@index')->name('home.dashboard');

    //any aceita qualquer tipo de requisição
    Route::any('/historic-search', 'Admin\BalanceController@searchHistoric')->name('historic.search');
    Route::post('/transfer', 'Admin\BalanceController@transferStore')->name('tranfer.store');
    Route::post('/confirm', 'Admin\BalanceController@confirmTransfer')->name('confirm.store');
    Route::post('/deposit', 'Admin\BalanceController@depositStore')->name('deposit.store');
    Route::post('/withdrawn', 'Admin\BalanceController@withdrawStore')->name('withdraw.store');
});

Route::get('/meu-perfil', 'Admin\UserController@profile')->name('profile')->middleware('auth');
Route::post('/atualizar-perfil', 'Admin\UserController@profileUpdate')->name('profile.update')->middleware('auth');

Route::get('/', 'Site\SiteController@index')->name('home');


Auth::routes();

// Route::get('/home', function() {
//     return view('home');
// })->name('home')->middleware('auth');
