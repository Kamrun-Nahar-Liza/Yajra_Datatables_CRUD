<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable = [
        'designation_name', 'designation_details'
       ];

       public function Members() 
       {
           return $this->hasMany(Member::class);
       }
}
