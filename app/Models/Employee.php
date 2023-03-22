<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $guarded = [], $appends = ['full_name'];

    public function note()
    {
        return $this->morphOne(Note::class, 'noteable');
    }

    //getFullnameAttribute
    public function getFullnameAttribute()
    {
    
        return $this->first_name . " " . $this->last_name;
    
    }
}
