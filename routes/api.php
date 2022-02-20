<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('/api/doc/import','API\DocumentController@import');

Route::apiResources([
    'room' => 'API\RoomController',
    'car' => 'API\CarController',
    'doc' => 'API\DocumentController',
    'maintenance' => 'API\MaintenanceController',
    'log' => 'API\LogController',
    'user' => 'API\UserController',
    'company' => 'API\CompanyController',
    'driver' => 'API\DriverController',
    'vendor' => 'API\VendorController',
    'division' => 'API\DivisionController',
    'employee' => 'API\EmployeeController',
    'export' => 'API\ExportController',
]);

Route::middleware('auth:api')->get('/user', function (Request $request){
    return $request->user();
});