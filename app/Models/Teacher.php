<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table="teacher";

    public function student()  
    {  
        
    //    return $this->belongsTo(Student::class);  
       return $this->hasOneThrough(Question::class,Student::class);  
    //    return $this->belongsToMany(Student::class); 
    }  
   
}
