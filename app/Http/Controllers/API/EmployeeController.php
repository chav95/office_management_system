<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;

class EmployeeController extends Controller
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
            if($request->action == 'create'){
                self::validateEmployee($request);

                $employee = new Employee;
                $employee->name = $request->name;
                $employee->nik = $request->nik;
                $employee->name = $request->name;
                $employee->npwp = $request->npwp;
                $employee->entry_date = date('Y-m-d', strtotime($request->entry_date));
                $employee->gaji_tunjangan = $request->gaji_tunjangan;
                $employee->terima_pph = $request->terima_pph;
                $employee->total_terima_lain = $request->total_terima_lain;
                $employee->total_potongan_lain = $request->total_potongan_lain;
                $employee->total_potongan_pph = $request->total_potongan_pph;
                $employee->jumlah_penerimaan = $request->jumlah_penerimaan;
                $employee->jumlah_potongan = $request->jumlah_potongan;
                $employee->penerimaan_bersih = $request->penerimaan_bersih;
                $employee->pengurang = $request->pengurang;
                $employee->penerimaan = $request->penerimaan;

                $employee->created_by = auth('api')->user()->id;
                $employee->save();

                return response()->json(array('success' => true, 'last_insert_id' => $employee->id), 200);
            }else if($request->action == 'edit'){
                self::validateEmployee($request);
                
                return response()->json(array(
                    'success' => true, 
                    'result' => 
                        Employee::where('id', $request->id)->update([
                            'name' => $request->name,
                            'nik' => $request->nik,
                            'name' => $request->name,
                            'npwp' => $request->npwp,
                            'entry_date' => date('Y-m-d', strtotime($request->entry_date)),
                            'gaji_tunjangan' => $request->gaji_tunjangan,
                            'terima_pph' => $request->terima_pph,
                            'total_terima_lain' => $request->total_terima_lain,
                            'total_potongan_lain' => $request->total_potongan_lain,
                            'total_potongan_pph' => $request->total_potongan_pph,
                            'jumlah_penerimaan' => $request->jumlah_penerimaan,
                            'jumlah_potongan' => $request->jumlah_potongan,
                            'penerimaan_bersih' => $request->penerimaan_bersih,
                            'pengurang' => $request->pengurang,
                            'penerimaan' => $request->penerimaan,
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
        if($id == 'getEmployeeData'){
            return Employee::orderBy('name', 'ASC')->get();
        }else if($id == 'getEmployeeList'){
            return Employee::orderBy('name', 'ASC')->paginate(10);
        }else{ //$id is employee id
            return Employee::find($id);
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
            'result' => Employee::destroy($id)
        ), 200);
    }

    public function validateEmployee($request){
        return $this->validate($request, [
            'name' => 'required|string|max:191',
            'nik' => 'required|string|max:191|unique:employees,nik,'.$request->id,
            'entry_date' => 'required|date',
            'npwp' => 'nullable|string',
            'gaji_tunjangan' => 'integer|digits_between:1,17',
            'terima_pph' => 'integer|digits_between:1,17',
            'total_terima_lain' => 'integer|digits_between:1,17',
            'total_potongan_lain' => 'integer|digits_between:1,17',
            'total_potongan_pph' => 'integer|digits_between:1,17',
            'jumlah_penerimaan' => 'integer|digits_between:1,17',
            'jumlah_potongan' => 'integer|digits_between:1,17',
            'penerimaan_bersih' => 'integer|digits_between:1,17',
            'pengurang' => 'integer|digits_between:1,17',
            'penerimaan' => 'integer|digits_between:1,17',
        ]);
    }
}
