<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerImage extends Model
{
    //
    protected $fillable = ['image'];

    public function customer()
    {
        return $this->belongsTo('App\Customer' ,'customer_id');
    }
}
