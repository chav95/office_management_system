<?php

namespace App\Exports;

use App\CarBooking;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class CarBookingExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths
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
        return CarBooking::query()->whereBetween('created_at', $this->date_arr);
    }

    public function map($row): array{
        return [
           $row->tanggal,
           $row->jam_awal,
           $row->jam_akhir,
           $row->destination,
           $row->purpose,
           $row->notes,
        ];
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jam Awal',
            'Jam Akhir',
            'Tujuan',
            'Keperluan',
            'Catatan Tambahan'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 12,
            'B' => 10,
            'C' => 10,
            'D' => 35,
            'E' => 45,
            'F' => 20,
        ];
    }
}
