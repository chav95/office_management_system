<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    public function car(){
        return $this->hasMany('App\Car');
    }
}
