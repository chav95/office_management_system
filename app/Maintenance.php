<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    public function user(){
        return $this->belongsTo('App\User', 'created_by');
    }
}
