<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
  

   
    public function getPosition($value)
    {
        return $this->position == $value;
    }
}
