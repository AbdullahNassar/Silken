<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogTrans extends Model
{
    //
    protected $fillable = ['title' ,'description' ,'lang' ,'blog_id'];

    public function blog(){
        return $this->belongsTo(Blog::class ,'blog_id');
    }
}
