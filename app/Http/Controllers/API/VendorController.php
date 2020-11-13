<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vendor;

class VendorController extends Controller
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
        if($request->act){
            if($request->act == 'create'){
                $vendor = new Vendor;
                $vendor->name = $request->name;
                $vendor->save();

                return response()->json(array(
                    'success' => true, 'last_insert_id' => $vendor->id
                ), 200);
            }else if($request->act == 'edit'){
                return response()->json(array(
                    'result' => 
                        Vendor::where('id', $request->id)->update([
                            'name' => $request->name,
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
        if($id === 'getVendorData'){
            return Vendor::orderBy('name', 'ASC')->where('status', 1)->get();
        }else if($id === 'getVendorList'){
            return Vendor::orderBy('name', 'ASC')->where('status', 1)->paginate(10);
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
            'result' => Vendor::where('id', $id)->update(['status' => 0])
        ), 200);
    }
}
