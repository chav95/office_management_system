<?php

namespace App\Http\Controllers;
use App\Exports\CarBookingExport;
use App\Exports\DocumentExport;
use App\Exports\MaintenanceExport;
use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function car_booking($date_range) 
    {
        return Excel::download(new CarBookingExport($date_range), 'export_file.xlsx');
    }
    public function document($date_range) 
    {
        return Excel::download(new DocumentExport($date_range), 'export_file.xlsx');
    }
    public function maintenance($date_range) 
    {
        return Excel::download(new MaintenanceExport($date_range), 'export_file.xlsx');
    }
}
