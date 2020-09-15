<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Car;
use App\CarBooking;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookCarNotif;
use App\Mail\BookCarStatus;
use App\Mail\BookCarDone;

class CarController extends Controller
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
            if($request->action == 'create_car'){
                $car = new Car;
                $car->company_id = $request->company;
                $car->type = $request->type;
                $car->engine_cc = $request->engine;
                $car->police_number = $request->police_number;
                $car->driver_id = 0; //$request->driver;
                $car->lease_start = date('Y-m-d H:i:s', strtotime($request->lease_start));
                $car->lease_due = date('Y-m-d H:i:s', strtotime($request->lease_due));
                $car->lease_price = $request->lease_price;
                $car->vendor_id = $request->vendor;
                $car->division_id = $request->division;
                $car->created_by = auth('api')->user()->id;
                $car->save();

                return response()->json(array('success' => true, 'last_insert_id' => $car->id), 200);
            }else if($request->action == 'edit_car'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        Car::where('id', $request->id)->update([
                            'company_id' => $request->company,
                            'type' => $request->type,
                            'engine_cc' => intval($request->engine),
                            'police_number' => $request->police_number,
                            // 'driver_id' => $request->driver_id,
                            'lease_start' => date('Y-m-d H:i:s', strtotime($request->lease_start)),
                            'lease_due' => date('Y-m-d H:i:s', strtotime(intval($request->lease_due))),
                            'lease_price' => intval($request->lease_price),
                            'vendor_id' => $request->vendor,
                            'division_id' => $request->division
                        ])
                ), 200);
            }else if($request->action === 'create_booking'){
                $booking = new CarBooking;
                $booking->tanggal = date('Y-m-d H:i:s', strtotime($request->tanggal));
                $booking->jam_awal = $request->jam_awal;
                // $booking->jam_akhir = $request->jam_akhir;
                $booking->destination = $request->destination;
                $booking->purpose = $request->purpose;
                $booking->division = 0; //$request->division;
                $booking->car_id = 0; //$request->car;
                $booking->booked_by = auth('api')->user()->id;
                $booking->save();

                // Mail::to('om@jtd.co.id')->queue(new BookCarNotif($booking));
                Mail::to(User::find(6)->email)->send(new BookCarNotif(CarBooking::with('user', 'car')->find($booking->id)));

                return response()->json(array('success' => true, 'last_insert_id' => $booking->id), 200);
            }else if($request->action === 'edit_booking'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        CarBooking::where('id', $request->id)->update([
                            'tanggal' => date('Y-m-d H:i:s', strtotime($request->tanggal)),
                            'jam_awal' => $request->jam_awal,
                            'jam_akhir' => $request->jam_akhir,
                            'destination' => $request->destination,
                            'purpose' => $request->purpose,
                        ])
                ), 200);
            }else if($request->action === 'assign'){
                $booking = CarBooking::find($request->booking_id);

                $selected_car = Car::find($request->car_id);
                // return response()->json(array('success' => true, 'item' => $selected_car), 200);
                
                if($selected_car->police_number !== '-'){ //return CarBooking::find($request->booking_id)->tanggal;
                    $check_existing_booking = CarBooking::with('car', 'user')
                        ->where('tanggal', '=', date('Y-m-d', strtotime($booking->tanggal)))
                        ->where('car_id', '=', $request->car_id)
                        ->where('status', '!=', 2)
                        ->get(); //return $check_existing_booking;
            
                    foreach($check_existing_booking as $item){
                        // for($i = $booking->jam_awal; $i <= $request->jam_akhir; $i++){
                            // if(($item->jam_awal <= $i) && ($i <= $item->jam_akhir)){
                            if($item->jam_awal == $booking->jam_awal){
                                $book_time = date('M n, Y', strtotime($item->tanggal)).' - '.$item->jam_awal.'.00';
                                return response()->json(array(
                                    'success' => false, 
                                    'msg' => 'Choosen Car Already Booked At: '.$item->jam_awal.'.00'
                                ), 200);
                            }
                        // }
                    }

                    $check_driver_schedule = CarBooking::with('car', 'user', 'driver')
                        ->where('tanggal', '=', date('Y-m-d', strtotime($booking->tanggal)))
                        ->where('driver_id', '=', $request->driver_id)
                        ->where('status', '!=', 2)
                        ->get();
            
                    foreach($check_driver_schedule as $item){
                        // for($i = $request->jam_awal; $i <= $request->jam_akhir; $i++){
                            // if(($item->jam_awal <= $i) && ($i <= $item->jam_akhir)){
                            if($item->jam_awal = $booking->jam_awal){
                                $book_time = date('M n, Y', strtotime($item->tanggal)).' - '.$item->jam_awal.'.00';
                                return response()->json(array(
                                    'success' => false, 
                                    'msg' => 'Choosen Driver Already Booked At: '.$item->jam_awal.'.00'
                                ), 200);
                            }
                        // }
                    }
                }

                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        CarBooking::where('id', $request->booking_id)->update([
                            'car_id' => $request->car_id,
                            'driver_id' => $request->driver_id,
                            'notes' => $request->notes,
                            'status' => 1,
                        ]),
                    'mail' => Mail::to(User::find(CarBooking::find($request->booking_id)->booked_by)->email)
                        ->send(new BookCarStatus(CarBooking::with('user', 'car', 'driver')->find($request->booking_id)))
                ), 200);
            }else if($request->action == 'reject'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        CarBooking::where('id', $request->booking_id)->update([
                            'notes' => $request->notes,
                            'status' => -1,
                        ]),
                    'mail' => Mail::to(User::find(CarBooking::find($request->booking_id)->booked_by)->email)
                        ->send(new BookCarStatus(CarBooking::with('user', 'car', 'driver')->find($request->booking_id)))
                ), 200);
            }else if($request->action == 'finish'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        CarBooking::where('id', $request->booking_id)->update([
                            'jam_akhir' => date('Y-m-d H:i:s'),
                            'status' => 2,
                        ]),
                    'mail' => Mail::to(User::find(6)->email)->send(new BookCarDone(CarBooking::with('user', 'car')->find($request->booking_id)))
                ), 200);
            }else if($request->action == 'cancel'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        CarBooking::where('id', $request->booking_id)->update([
                            'notes' => $request->notes,
                            'status' => -2,
                        ]),
                    'mail' => Mail::to(User::find(6)->email)->send(new BookCarDone(CarBooking::with('user', 'car')->find($request->booking_id)))
                ), 200);
            }else if($request->action == 'cancel_reject'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        CarBooking::where('id', $request->booking_id)->update([
                            'notes' => '',
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
        if($id === 'getCarList'){
            $result = Car::with('company', 'division', 'vendor', 'driver')->get();
        }else if($id === 'getCarData'){
            $result = Car::with('today_booking', 'today_booking.user', 'company', 'division', 'vendor', 'driver')->paginate(10);
        }else if($id === 'getBookingData'){
            $result = CarBooking::with('car', 'driver', 'user', 'division')
                ->where('car_id', '>', 0)
                ->where('tanggal', '>=', date('Y-m-d'))
                ->orderByRaw('FIELD(status, 1, 2, -2)')
                ->orderBy('tanggal', 'ASC')
                ->orderBy('jam_awal', 'ASC')
                ->paginate(10);
        }else if($id === 'getBookingHistory'){
            $result = CarBooking::with('car', 'driver', 'user', 'division')
                // ->where('car_id', '>', 0)
                ->where('tanggal', '<', date('Y-m-d'))
                // ->orderByRaw('FIELD(status, 1, 2, -2)')
                ->orderBy('tanggal', 'DESC')
                ->orderBy('jam_awal', 'ASC')
                ->paginate(10);
        }else if($id === 'getPendingBooking'){
            $result = CarBooking::with('user', 'division')
                ->where('car_id', '=', 0)
                ->where('tanggal', '>=', date('Y-m-d'))
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
            'result' => $item_class == 'booking' 
                ? CarBooking::where('id', $item_id)->delete()
                : Car::where('id', $item_id)->delete()
        ), 200);
    }
}
