<?php

namespace App\Imports;

use App\EmployeeExtra;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use DateTime;

class SalaryExtraImport implements ToModel, WithStartRow
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
        
        return new EmployeeExtra([
            'year' => $row[0],
            'month' => $row[1],
            'nik' => $row[2],
            'keterangan' => $row[3],
            'jenis' => $row[4],
            'nominal' => $row[5],
            'created_by'  => auth('api')->user()->id,
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
