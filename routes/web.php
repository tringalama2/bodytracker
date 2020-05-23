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

Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['verify' => true]);

Route::get('/home/{unit?}/{interval?}', 'HomeController@index')
  ->name('home');

Route::resource('entries', 'EntryController');



// profile routes
Route::get('/profile/create', 'ProfileController@create')
  ->name('profile.create');
Route::post('/profile', 'ProfileController@store')
  ->name('profile.store');
Route::get('/profile', 'ProfileController@edit')
  ->name('profile.edit');
Route::put('/profile', 'ProfileController@update')
  ->name('profile.update');

  // preference routes
  Route::get('/preference/create', 'PreferenceController@create')
    ->name('preference.create');
  Route::post('/preference', 'PreferenceController@store')
    ->name('preference.store');
  Route::get('/preference', 'PreferenceController@edit')
    ->name('preference.edit');
  Route::put('/preference', 'PreferenceController@update')
    ->name('preference.update');
