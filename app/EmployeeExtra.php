<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeExtra extends Model
{
    protected $fillable = [
        'year', 'month', 'nik', 'keterangan', 'jenis', 'nominal', 'created_by',
    ];
}
