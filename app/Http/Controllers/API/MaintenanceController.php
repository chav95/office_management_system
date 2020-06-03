<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Maintenance;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewDocNotif;
use App\Mail\UpcomingDocNotif;

class MaintenanceController extends Controller
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
            if($request->action == 'create_maintenance'){
                $maintenance = new Maintenance;
                $maintenance->name = $request->name;
                $maintenance->due_date = date('Y-m-d', strtotime($request->due_date));
                $maintenance->notif_date = date('Y-m-d', strtotime($request->notif_date));
                $maintenance->description = $request->description;
                $maintenance->created_by = auth('api')->user()->id;
                $maintenance->save();
                
                // Mail::to('om@jtd.co.id')->send(new BookCarNotif($booking));
                // Mail::to('chavinpradana@gmail.com')->send(new NewDocNotif($maintenance));

                // if(date('Y-m-d') >= $maintenance->notif_date){
                //     Mail::to('chavinpradana@gmail.com')->send(new UpcomingDocNotif($maintenance));
                // }

                return response()->json(array('success' => true, 'last_insert_id' => $maintenance->id), 200);
            }else if($request->action == 'edit_maintenance'){
                // if(date('Y-m-d') >= $request->notif_date){
                //     Mail::to('chavinpradana@gmail.com')->send(new UpcomingDocNotif(Maintenance::find($request->id)));
                // }

                return response()->json(array(
                    'success' => true, 
                    // 'mail' => date('Y-m-d') >= $request->notif_date && date('Y-m-d') <= $request->due_date
                    //     ? Mail::to('chavinpradana@gmail.com')->send(new UpcomingDocNotif(Maintenance::find($request->id)))
                    //     : null,
                    'result' => 
                        Maintenance::where('id', $request->id)->update([
                            'name' => $request->name,
                            'due_date' => date('Y-m-d', strtotime($request->due_date)),
                            'notif_date' => date('Y-m-d', strtotime($request->notif_date)),
                            'description' => $request->description,
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
        if($id === 'getMaintenanceData'){
            $result = Maintenance::with('user')->orderBy('notif_date', 'ASC')->paginate(10);
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
        return response()->json(array(
            'success' => true,
            'result' => Maintenance::where('id', $id)->delete()
        ), 200);
    }
}
