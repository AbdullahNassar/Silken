<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerTrans extends Model
{
    //
    protected $fillable = ['title' ,'lang'];

    public function customer(){
        return $this->belongsTo('App\Customer' ,'customer_id');
    }
}
