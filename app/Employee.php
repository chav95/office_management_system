<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'year', 'month', 'name', 'nik', 'npwp', 'entry_date', 'gaji_tunjangan',
        'terima_pph', 'total_terima_lain', 'total_potongan_lain', 'total_potongan_pph', 'jumlah_penerimaan', 'jumlah_potongan',
        'penerimaan_bersih', 'pengurang', 'penerimaan', 'created_by',
    ];
}
