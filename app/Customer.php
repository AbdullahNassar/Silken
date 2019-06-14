<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    public function details(){
        return $this->hasMany('App\CustomerTrans' ,'customer_id');
    }

    public function translated(){
        return $this->details()->where('lang' ,app()->getLocale())->first();
    }

    public function english(){
        return $this->details()->where('lang' ,'en')->first();
    }

    public function arabic(){
        return $this->details()->where('lang' ,'ar')->first();
    }

    public function images(){
        return $this->hasMany('App\CustomerImage' ,'customer_id');
    }
}
