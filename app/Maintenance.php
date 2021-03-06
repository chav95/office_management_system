<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'no_document', 'document_date', 'due_date', 'description', 'created_by',
    ];
    
    public function user(){
        return $this->belongsTo('App\User', 'created_by');
    }
}
