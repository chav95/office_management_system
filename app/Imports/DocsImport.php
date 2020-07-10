<?php

namespace App\Imports;

use App\Document;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class Docsimport implements ToModel, WithStartRow
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
        
        return new Document([
            'name'  => $row[0],
            'no_document' => $row[1],
            'document_date'  => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]),
            'due_date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]),
            'created_by'  => auth('api')->user()->id,
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }
}
