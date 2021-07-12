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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('designations','DesignationController');

Route::post('designations/update', 'DesignationController@update')->name('designations.update');

Route::get('designations/destroy/{id}', 'DesignationController@destroy');


Route::resource('members','MemberController');

Route::post('members/update', 'MemberController@update')->name('members.update');

Route::get('members/destroy/{id}', 'MemberController@destroy');
