<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Students extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'phone',
        'email',
        'personal_photo',
        'birth_date', 
        'educational_level',
        'gender',
        'location',
        'password',     
    ];

    public function getPersonal_photoPathAttribute()
    {  
        return  "app/public/images/student". $this->personal_photo; 
    }

    public function StudentCourses()
    {
       return $this->hasMany(Student_course::class);
    }
}
