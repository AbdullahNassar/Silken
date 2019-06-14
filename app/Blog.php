<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    //
    public function details(){
        return $this->hasMany(BlogTrans::class ,'blog_id');
    }

    public function translated(){
        return $this->details()->where('lang' ,app()->getLocale())->first();
    }

    public function arabic(){
        return $this->details()->where('lang' ,'ar')->first();
    }

    public function english(){
        return $this->details()->where('lang' ,'en')->first();
    }

    public function user(){
        return $this->belongsTo('App\User' ,'user_id');
    }

}
