<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    public function booking(){
        return $this->hasMany('App\CarBooking')->latest();
    }

    public function today_booking(){
        $today = date('Y-m-d');
        return $this->hasMany('App\CarBooking')->where('tanggal', $today);
    }

    public function user(){
        return $this->hasManyThrough('App\User', 'App\CarBooking', 'booked_by', 'id');
    }
}
