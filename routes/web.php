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

// use App\Mail\BookRoomNotif;
// use Illuminate\Support\Facades\Mail;

// Route::get('/mail', function(){
    // Mail::to('email@email.com')->send(new BookRoomNotif());

    // return new BookRoomNotif();
// });

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/manage-users', 'HomeController@index')->middleware('can:isAdmin');

Route::get('{path}',"HomeController@index")->where('path', '([A-z\d\-\/_.]+)?');