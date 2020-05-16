<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function car(){
        return $this->hasMany('App\Car');
    }
}
