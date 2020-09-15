<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DateTime;

class SalaryImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row[0])) {
            return null;
        }
        
        return new Employee([
            'year' => $row[0],
            'month' => $row[1],
            'name' => $row[2],
            'nik' => $row[3],
            'npwp' => $row[4],
            // 'entry_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]),
            'entry_date' => strval($row[5]),
            // 'entry_date' => date('Y-m-d', strtotime($row[5])),
            'gaji_tunjangan' => $row[6],
            'terima_pph' => $row[7],
            'total_terima_lain' => $row[8],
            'total_potongan_lain' => $row[9],
            'total_potongan_pph' => $row[10],
            'jumlah_penerimaan' => $row[11],
            'jumlah_potongan' => $row[12],
            'penerimaan_bersih' => $row[13],
            'pengurang' => $row[14],
            'penerimaan' => $row[15],
            'created_by'  => auth('api')->user()->id,
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
