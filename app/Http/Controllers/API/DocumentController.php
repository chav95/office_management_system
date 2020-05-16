<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Document;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewDocNotif;
use App\Mail\UpcomingDocNotif;

class DocumentController extends Controller
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
            if($request->action == 'create_doc'){
                $doc = new Document;
                $doc->type = $request->type;
                $doc->name = $request->name;
                $doc->created_by = auth('api')->user()->id;
                $doc->notif_date = date('Y-m-d', strtotime($request->notif_date));
                $doc->due_date = date('Y-m-d', strtotime($request->due_date));
                $doc->save();
                
                // Mail::to('om@jtd.co.id')->send(new BookCarNotif($booking));
                Mail::to('chavinpradana@gmail.com')->send(new NewDocNotif($doc));

                if(date('Y-m-d') >= $doc->notif_date){
                    Mail::to('chavinpradana@gmail.com')->send(new UpcomingDocNotif($doc));
                }

                return response()->json(array('success' => true, 'last_insert_id' => $doc->id), 200);
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
        if($id === 'getDocData'){
            $result = Document::orderBy('notif_date', 'ASC')->get();
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
        //
    }
}
