<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Car;
use App\CarBooking;

class CarController extends Controller
{
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
            if($request->action === 'create_booking'){
                $selected_car = Car::find($request->car);
                // return response()->json(array('success' => true, 'item' => $selected_car), 200);
                
                if($selected_car->police_number !== '-'){
                    $check_existing_booking = CarBooking::with('car', 'user')
                        ->where('tanggal', '=', date('Y-m-d', strtotime($request->tanggal)))
                        ->get();
            
                    foreach($check_existing_booking as $item){
                        for($i = $request->jam_awal; $i <= $request->jam_akhir; $i++){
                            if(($item->jam_awal <= $i) && ($i <= $item->jam_akhir)){
                                $book_time = date('M n, Y', strtotime($item->tanggal)).' - '.$item->jam_awal.'.00 s/d '.$item->jam_akhir.'.00';
                                return response()->json(array(
                                    'success' => false, 
                                    'msg' => 'Choosen Car Already Booked At: '.$item->jam_awal.'.00 s/d '.$item->jam_akhir.'.00'
                                ), 200);
                            }
                        }
                    }
                }   

                $booking = new CarBooking;
                $booking->tanggal = date('Y-m-d H:i:s', strtotime($request->tanggal));
                $booking->jam_awal = $request->jam_awal;
                $booking->jam_akhir = $request->jam_akhir;
                $booking->destination = $request->destination;
                $booking->purpose = $request->purpose;
                $booking->car_id = $request->car;
                $booking->booked_by = auth('api')->user()->id;
                $booking->save();

                return response()->json(array('success' => true, 'last_insert_id' => $booking->id), 200);
            }
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
        if($id === 'getCarData'){
            $result = Car::with('today_booking', 'today_booking.user')->get();
        }else if($id === 'getBookingData'){
            $result = CarBooking::with('car', 'user')
                ->where('tanggal', '>=', date('Y-m-d'))
                ->orderBy('tanggal', 'ASC')
                ->orderBy('jam_awal', 'ASC')
                ->get();
        }

        return $result;
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
        $item_class = explode('-', $id)[0];
        $item_id = explode('-', $id)[1];
        
        return response()->json(array(
            'success' => true, 
            'result' => CarBooking::where('id', $item_id)->delete()
        ), 200);
    }
}
