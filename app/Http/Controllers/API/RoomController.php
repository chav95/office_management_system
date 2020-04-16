<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Room;
use App\RoomBooking;

class RoomController extends Controller
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
            if($request->action === 'create_booking'){
                $check_existing_booking = RoomBooking::with('room', 'user')
                    ->where('tanggal', '=', date('Y-m-d', strtotime($request->tanggal)))
                    ->get();
                
                foreach($check_existing_booking as $item){
                    for($i = $request->jam_awal; $i <= $request->jam_akhir; $i++){
                        if(($item->jam_awal <= $i) && ($i <= $item->jam_akhir)){
                            $book_time = date('M n, Y', strtotime($item->tanggal)).' - '.$item->jam_awal.'.00 s/d '.$item->jam_akhir.'.00';
                            return response()->json(array(
                                'success' => false, 
                                'msg' => 'Choosen Room Already Booked At: '.$item->jam_awal.'.00 s/d '.$item->jam_akhir.'.00'
                            ), 200);
                        }
                    }
                }
                
                $booking = new RoomBooking;
                $booking->tanggal = date('Y-m-d', strtotime($request->tanggal));
                $booking->jam_awal = $request->jam_awal;
                $booking->jam_akhir = $request->jam_akhir;
                $booking->participant = $request->participant;
                $booking->purpose = $request->purpose;
                $booking->room_id = $request->room;
                $booking->options = $request->options;
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
        if($id === 'getRoomData'){
            $result = Room::with('today_booking', 'today_booking.user')->get();
            // $room_last_booking = $result->booking->last();

            // $result->booking = $room_last_booking;
        }else if($id === 'getBookingData'){
            $result = RoomBooking::with('room', 'user')
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
            'result' => RoomBooking::where('id', $item_id)->delete()
        ), 200);
    }
}
