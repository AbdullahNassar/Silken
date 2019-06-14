<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AboutTrans extends Model
{
    //
    protected $fillable = ['title' ,'description' ,'lang' ,'about_id'];
    public function about(){
        return $this->belongsTo(About::class ,'about_id');
    }
}
