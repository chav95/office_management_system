<?php

namespace App\Exports;

use App\Maintenance;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class MaintenanceExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths
{
    use Exportable;

    protected $date_arr;
    protected $start_date;
    protected $end_date;

    public function __construct($date_range)
    {
        $this->date_arr = explode('_', $date_range);
        $this->date_arr[0] = date($this->date_arr[0]);
        $this->date_arr[1] = date($this->date_arr[1]);
    }

    public function query()
    {
        return Maintenance::query()->whereBetween('document_date', $this->date_arr);
    }

    public function map($row): array{
        return [
           $row->name,
           $row->no_document,
           $row->document_date,
           $row->due_date,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Dokumen',
            'Nomor Dokumen',
            'Tanggal Dokumen',
            'Berlaku Sampai',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 20,
            'C' => 15,
            'D' => 15,
        ];
    }
}
