<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactTrans extends Model
{
    //
    protected $fillable =['title' ,'description' ,'lang' ,'contact_id'];
    public function contact(){
        return $this->belongsTo(Contact::class ,'contact_id');
    }
}
