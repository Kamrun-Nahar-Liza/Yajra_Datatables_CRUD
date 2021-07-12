<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Member extends Model
{
    protected $fillable = [
        'member_name', 'designation_id'
       ];


       public function Designation()
       {
           return $this->belongsTo(Designation::class, 'designation_id', 'id');
       }
}
