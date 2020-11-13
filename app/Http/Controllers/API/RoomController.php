<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Room;
use App\RoomBooking;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookRoomNotif;
use App\Mail\BookRoomStatus;
use App\Mail\BookRoomDone;

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
            if($request->action === 'create_room'){
                $room = new Room;
                $room->name = $request->name;
                $room->capacity = $request->capacity;
                $room->created_by = auth('api')->user()->id;
                $room->save();

                return response()->json(array('success' => true, 'last_insert_id' => $room->id), 200);
            }else if($request->action === 'edit_room'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        Room::where('id', $request->id)->update([
                            'name' => $request->name,
                            'capacity' => $request->capacity,
                        ])
                ), 200);
            }else if($request->action === 'create_booking'){
                $check_existing_booking = RoomBooking::with('room', 'user')
                    ->where('tanggal', '=', date('Y-m-d', strtotime($request->tanggal)))
                    ->where('room_id', '=', $request->room)
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
                $booking->division = $request->division;
                $booking->room_id = $request->room;
                $booking->options = $request->options;
                $booking->booked_by = auth('api')->user()->id;
                $booking->save();

                // Mail::to('om@jtd.co.id')->send(new BookRoomNotif($booking));
                Mail::to(User::find(6)->email)->send(new BookRoomNotif(RoomBooking::with('user', 'room')->find($booking->id)));

                return response()->json(array('success' => true, 'last_insert_id' => $booking->id), 200);
            }else if($request->action === 'edit_booking'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        RoomBooking::where('id', $request->id)->update([
                            'tanggal' => date('Y-m-d', strtotime($request->tanggal)),
                            'jam_awal' => $request->jam_awal,
                            'jam_akhir' => $request->jam_akhir,
                            'participant' => $request->participant,
                            'purpose' => $request->purpose,
                            'division' => $request->division,
                            'room_id' => $request->room,
                            'options' => $request->options,
                        ])
                ), 200);
            }else if($request->action === 'assign'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        RoomBooking::where('id', $request->booking_id)->update([
                            'room_id' => $request->room_id,
                            'notes' => $request->notes,
                            'status' => 1,
                        ]),
                    'mail' => Mail::to(User::find(RoomBooking::find($request->booking_id)->booked_by)->email)
                        ->send(new BookRoomStatus(RoomBooking::with('user', 'room')->find($request->booking_id)))
                ), 200);
            }else if($request->action == 'reject'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        RoomBooking::where('id', $request->booking_id)->update([
                            'notes' => $request->notes,
                            'status' => -1,
                        ]),
                    'mail' => Mail::to(User::find(RoomBooking::find($request->booking_id)->booked_by)->email)
                        ->send(new BookRoomStatus(RoomBooking::with('user', 'room')->find($request->booking_id)))
                ), 200);
            }else if($request->action == 'finish'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        RoomBooking::where('id', $request->booking_id)->update([
                            'status' => 2,
                        ]),
                    'mail' => Mail::to(User::find(6)->email)->send(new BookRoomDone(RoomBooking::with('user', 'room')->find($request->booking_id)))
                ), 200);
            }else if($request->action == 'cancel'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        RoomBooking::where('id', $request->booking_id)->update([
                            'notes' => $request->notes,
                            'status' => -2,
                        ]),
                    'mail' => Mail::to(User::find(6)->email)->send(new BookRoomDone(RoomBooking::with('user', 'room')->find($request->booking_id)))
                ), 200);
            }else if($request->action == 'cancel_reject'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        RoomBooking::where('id', $request->booking_id)->update([
                            'notes' => null,
                            'status' => 0,
                        ])
                ), 200);
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
        if($id === 'getRoomList'){
            $result = Room::with('today_booking', 'today_booking.user')->where('status', 1)->get();
        }else if($id === 'getRoomData'){
            $result = Room::with('today_booking', 'today_booking.user')->where('status', 1)->paginate(10);
            // $room_last_booking = $result->booking->last();

            // $result->booking = $room_last_booking;
        }else if($id === 'getBookingData'){
            $result = RoomBooking::with('room', 'user', 'division')
                ->where('tanggal', '>=', date('Y-m-d'))
                ->where('status', '>', 0)
                ->orWhere('status', '=', -2)
                ->orderByRaw('FIELD(status, 1, 2, -2)')
                ->orderBy('tanggal', 'ASC')
                ->orderBy('jam_awal', 'ASC')
                ->paginate(10);
        }else if($id === 'getBookingHistory'){
            $result = RoomBooking::with('room', 'user', 'division')
                ->where('tanggal', '<', date('Y-m-d'))
                // ->where('status', '>', 0)
                // ->orWhere('status', '=', -2)
                // ->orderByRaw('FIELD(status, 1, 2, -2)')
                ->orderBy('tanggal', 'DESC')
                ->orderBy('jam_awal', 'ASC')
                ->paginate(10);
        }else if($id === 'getPendingBooking'){
            $result = RoomBooking::with('room', 'user', 'division')
                ->where('tanggal', '>=', date('Y-m-d'))
                ->where('status', '=', 0)
                ->orWhere('status', '=', -1)
                ->orderByRaw('FIELD(status, 1, 2, -2)')
                ->orderBy('created_at', 'DESC')
                ->orderBy('jam_awal', 'ASC')
                ->paginate(10);
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
            'result' => $item_class === 'booking'
                ? RoomBooking::where('id', $item_id)->delete()
                : Room::where('id', $item_id)->update(['status' => 0])
        ), 200);
    }
}
