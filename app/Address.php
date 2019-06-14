<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'addresses';
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'f_name',
        'l_name',
        'address',
        'phone',
        'email',
        'company_id',
    ];
    /**
    * Get the Order(s) attached to the Address.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function getFullName()
    {
        return "$this->f_name $this->l_name";
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
