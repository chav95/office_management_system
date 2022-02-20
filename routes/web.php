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

// Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('/login', 'Auth\LoginController@login');
// Route::post('/register', 'Auth\LoginController@register');
// Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
// Route::get('/logout', 'Auth\LoginController@logout');
Auth::routes();

Route::get('car_booking/export/{date_range}', 'ExportController@car_booking');
Route::get('document/export/{date_range}', 'ExportController@document');
Route::get('maintenance/export/{date_range}', 'ExportController@maintenance');

Route::get('/route', function() {
    $output = Artisan::call('route:cache');
    dd($output);
});
Route::get('/config', function() {
    $output = Artisan::call('config:cache');
    dd($output);
});
Route::get('/cache', function() {
    $output = Artisan::call('cache:clear');
    dd($output);
});
Route::get('/view', function() {
    $output = Artisan::call('view:clear');
    dd($output);
});

Route::get('/clear', function() {
    $output = [];
    
    array_push($output, Artisan::call('route:cache'));
    array_push($output, Artisan::call('config:cache'));
    array_push($output, Artisan::call('cache:clear'));
    array_push($output, Artisan::call('view:clear'));
    
    dd($output);
});

Route::get('images/{filename}', function ($filename)
{
    $path = storage_path() . '/app_image/' . $filename;

    if(!File::exists($path)) abort(404);

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
});

Route::get('/manage-users', 'HomeController@index')->middleware('can:isAdmin');

Route::get('{path}',"HomeController@index")->where('path', '([A-z\d\-\/_.]+)?');