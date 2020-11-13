<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Driver;
use App\Car;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->action){
            $result = response();
            if($request->action == 'create_driver'){
                $driver = new Driver;
                $driver->name = $request->name;
                
                if($driver->save()){ //add driver successful
                    $result = response()->json(array(
                        'success' => true, 
                        'result' => $request->car > 0
                                ? Car::where('id', $request->car)->update(['driver_id' => $driver->id,])
                                : 0
                    ), 200);
                }else{
                    $result = response()->json(array(
                        'success' => false, 
                        'message' => 'Failed To Add New Driver'
                    ), 200);
                }
            }else if($request->action == 'edit_driver'){
                if($request->car > 0){
                    $driver = Driver::with('car')->where('id', $request->id)->get();
                    // return $driver[0]->car->id;

                    if($driver[0]->car !== null){
                        Car::where('id', $driver[0]->car->id)
                            ->update(['driver_id' => 0]);
                    }
                }

                $result = response()->json(array(
                    'success' => true, 
                    'driver' => Driver::where('id', $request->id)->update(['name' => $request->name]),
                    'car' => $request->car > 0
                            ? Car::where('id', $request->car)->update(['driver_id' => $request->id,])
                            : 0
                ), 200);
            }

            return $result;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id === 'getDriverData'){
            return Driver::with('today_booking')->orderBy('name', 'ASC')->where('status', 1)->get();
        }else if($id === 'getDriverList'){
            return Driver::with('car')->orderBy('name', 'ASC')->where('status', 1)->paginate(10);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return response()->json(array(
            'success' => true,
            'result' => Driver::where('id', $id)->update(['status' => 0])
        ), 200);
    }
}
