<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Car;
use App\CarBooking;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookCarNotif;

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
            if($request->action === 'create_booking'){
                $booking = new CarBooking;
                $booking->tanggal = date('Y-m-d H:i:s', strtotime($request->tanggal));
                $booking->jam_awal = $request->jam_awal;
                $booking->jam_akhir = $request->jam_akhir;
                $booking->destination = $request->destination;
                $booking->purpose = $request->purpose;
                $booking->division = $request->division;
                $booking->car_id = 0; //$request->car;
                $booking->booked_by = auth('api')->user()->id;
                $booking->save();

                // Mail::to('om@jtd.co.id')->send(new BookCarNotif($booking));
                Mail::to('chavinpradana@gmail.com')->send(new BookCarNotif($booking));

                return response()->json(array('success' => true, 'last_insert_id' => $booking->id), 200);
            }else if($request->action === 'assign'){
                // $selected_car = Car::find($request->car);
                // // return response()->json(array('success' => true, 'item' => $selected_car), 200);
                
                // if($selected_car->police_number !== '-'){
                //     $check_existing_booking = CarBooking::with('car', 'user')
                //         ->where('tanggal', '=', date('Y-m-d', strtotime($request->tanggal)))
                //         ->where('car_id', '=', $request->car)
                //         ->get();
            
                //     foreach($check_existing_booking as $item){
                //         for($i = $request->jam_awal; $i <= $request->jam_akhir; $i++){
                //             if(($item->jam_awal <= $i) && ($i <= $item->jam_akhir)){
                //                 $book_time = date('M n, Y', strtotime($item->tanggal)).' - '.$item->jam_awal.'.00 s/d '.$item->jam_akhir.'.00';
                //                 return response()->json(array(
                //                     'success' => false, 
                //                     'msg' => 'Choosen Car Already Booked At: '.$item->jam_awal.'.00 s/d '.$item->jam_akhir.'.00'
                //                 ), 200);
                //             }
                //         }
                //     }
                // }

                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        CarBooking::where('id', $request->booking_id)->update([
                            'car_id' => $request->car_id,
                            'driver_id' => $request->driver_id,
                            'notes' => $request->notes,
                            'status' => 1,
                        ])
                ), 200);
            }else if($request->action == 'reject'){
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        CarBooking::where('id', $request->booking_id)->update([
                            'notes' => $request->notes,
                            'status' => -1,
                        ])
                ), 200);
            }else if($request->action == 'create_car'){
                $car = new Car;
                $car->company_id = $request->company;
                $car->type = $request->type;
                $car->engine_cc = $request->engine;
                $car->police_number = $request->police_number;
                $car->driver_id = $request->driver;
                $car->lease_start = date('Y-m-d H:i:s', strtotime($request->lease_start));
                $car->lease_due = date('Y-m-d H:i:s', strtotime($request->lease_due));
                $car->lease_price = $request->lease_price;
                $car->vendor_id = $request->vendor;
                $car->division_id = $request->division;
                $car->created_by = auth('api')->user()->id;
                $car->save();

                return response()->json(array('success' => true, 'last_insert_id' => $car->id), 200);
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
            $result = Car::with('today_booking', 'today_booking.user', 'company', 'division', 'vendor', 'driver')->get();
        }else if($id === 'getBookingData'){
            $result = CarBooking::with('car', 'driver', 'user', 'division')
                ->where('car_id', '>', 0)
                ->where('tanggal', '>=', date('Y-m-d'))
                ->orderBy('tanggal', 'ASC')
                ->orderBy('jam_awal', 'ASC')
                ->get();
        }else if($id === 'getPendingBooking'){
            $result = CarBooking::with('user', 'division')
                ->where('car_id', '=', 0)
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
            'result' => $item_class == 'booking' 
                ? CarBooking::where('id', $item_id)->delete()
                : Car::where('id', $item_id)->delete()
        ), 200);
    }
}
