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
            'company' => $row[0],
            'year' => $row[1],
            'month' => $row[2],
            'nik' => $row[3],
            'name' => $row[4],
            'npwp' => $row[5],
            // 'entry_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]),
            // 'entry_date' => strval($row[6]),
            'entry_date' => $row[6],
            // 'entry_date' => date('Y-m-d', strtotime($row[6])),
            'gaji_tunjangan' => $row[7],
            'terima_pph' => $row[8],
            'total_terima_lain' => $row[9],
            'total_potongan_lain' => $row[10],
            'total_potongan_pph' => $row[11],
            'jumlah_penerimaan' => $row[12],
            'jumlah_potongan' => $row[13],
            'penerimaan_bersih' => $row[14],
            'pengurang' => $row[15],
            'penerimaan' => $row[16],
            'created_by'  => auth('api')->user()->id,
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
