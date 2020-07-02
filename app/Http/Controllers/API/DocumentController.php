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
                $doc->name = $request->name;
                $doc->due_date = date('Y-m-d', strtotime($request->due_date));
                $doc->notif_date = date('Y-m-d', strtotime($request->notif_date));
                $doc->description = $request->description;
                $doc->created_by = auth('api')->user()->id;
                $doc->save();
                
                // Mail::to('om@jtd.co.id')->send(new BookCarNotif($booking));
                // Mail::to('chavinpradana@gmail.com')->send(new NewDocNotif($doc));

                // if(date('Y-m-d') >= $doc->notif_date){
                //     Mail::to('chavinpradana@gmail.com')->send(new UpcomingDocNotif($doc));
                // }

                return response()->json(array('success' => true, 'last_insert_id' => $doc->id), 200);
            }else if($request->action == 'edit_doc'){
                // if(date('Y-m-d') >= $request->notif_date){
                //     Mail::to('chavinpradana@gmail.com')->send(new UpcomingDocNotif(Document::find($request->id)));
                // }

                return response()->json(array(
                    'success' => true, 
                    'mail' => date('Y-m-d') >= $request->notif_date && date('Y-m-d') <= $request->due_date
                        ? Mail::to('chavinpradana@gmail.com')->send(new UpcomingDocNotif(Document::find($request->id)))
                        : null,
                    'result' => 
                        Document::where('id', $request->id)->update([
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
        if($id === 'getDocData'){
            $result = Document::with('user')
                ->where('due_date', '>=', date('Y-m-d'))
                ->orderBy('due_date', 'ASC')->paginate(10);

            // $four_weeks = date('Y-m-d', strtotime("+ 28 days"));
            // $result = Document::with('user')
            //     ->where('due_date', '<=', $four_weeks)
            //     ->where('due_date', '>', date('Y-m-d'))
            //     ->whereRaw("MOD(DATEDIFF(due_date, '$four_weeks'), 7) = 0")
            //     ->paginate(10);
            //     // ->toSql();
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
            'result' => Document::destroy($id)
            // 'result' => Document::where('id', $id)->delete()
        ), 200);
    }
}
