<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    public function user(){
        return $this->hasMany('App\User');
    }
    public function car(){
        return $this->hasMany('App\Car');
    }
    public function car_booking(){
        return $this->hasMany('App\CarBooking');
    }
    public function room_booking(){
        return $this->hasMany('App\RoomBooking');
    }
}
