<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomBooking extends Model
{
    // public $timestamps = true;

    public function room(){
        return $this->belongsTo('App\Room');
    }

    public function user(){
        return $this->belongsTo('App\USer', 'booked_by');
    }
    
    public function division(){
        return $this->belongsTo('App\Division', 'division');
    }
}
