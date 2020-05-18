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
        // return $this->hasMany('App\CarBooking')->where('tanggal', $today);
        return $this->hasMany('App\CarBooking')->whereDate('tanggal', '>=', $today);
    }

    public function user(){
        return $this->hasManyThrough('App\User', 'App\CarBooking', 'booked_by', 'id');
    }

    public function company(){
        return $this->belongsTo('App\Company');
    }
    public function driver(){
        return $this->belongsTo('App\Driver');
    }
    public function vendor(){
        return $this->belongsTo('App\Vendor');
    }
    public function division(){
        return $this->belongsTo('App\Division');
    }
}
