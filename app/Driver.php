<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function car(){
        return $this->hasOne('App\Car');
    }

    public function today_booking(){
        $today = date('Y-m-d');
        return $this->hasMany('App\CarBooking')->whereDate('tanggal', '>=', $today);
    }

    public function booking(){
        return $this->hasMany('App\CarBooking');
    }
}
