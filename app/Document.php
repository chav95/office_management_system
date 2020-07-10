<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'no_document', 'document_date', 'due_date', 'created_by',
    ];
    
    public function user(){
        return $this->belongsTo('App\User', 'created_by');
    }
}
