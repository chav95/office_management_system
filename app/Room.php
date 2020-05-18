<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // public $timestamps = true;

    public function booking(){
        return $this->hasMany('App\RoomBooking')->latest();
    }

    public function today_booking(){
        $today = date('Y-m-d');
        return $this->hasMany('App\RoomBooking')->whereDate('tanggal', '>=', $today);
    }

    public function user(){
        return $this->hasManyThrough('App\User', 'App\RoomBooking', 'booked_by', 'id');
    }
}
