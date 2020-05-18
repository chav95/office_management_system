<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarBooking extends Model
{
    public function car(){
        return $this->belongsTo('App\Car');
    }

    public function driver(){
        return $this->belongsTo('App\Driver');
    }

    public function user(){
        return $this->belongsTo('App\USer', 'booked_by');
    }
    
    public function division(){
        return $this->belongsTo('App\Division', 'division');
    }
}
