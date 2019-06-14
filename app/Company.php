<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function details()
    {
        return $this->hasMany(_Company::class,'company_id');
    }
    public function translated($local = null)
    {
        return $this->details()->where('locale_id',Locale::where('name',$local?:app()->getLocale())->first()->id)->first();
    }
    public function trash()
    {
        $this->details()->delete();
        $this->delete();
    }
}
