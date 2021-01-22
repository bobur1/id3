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
    return redirect()->route('form');
});


Route::get('form', 'FormController@index')->name('form');
Route::post('form', 'FormController@formSubmitted');
Route::post('final', 'FormController@finalQuestionSubmitted')->name('final');
Route::get('thank', 'FormController@thank')->name('thank');
Route::get('newForm', 'FormController@startNewForm')->name('newForm');
Route::post('normalForm', 'FormController@saveNormalForm')->name('submitNormalForm');
Route::post('changeLanguage', 'FormController@changeLanguage')->name('changeLanguage');

