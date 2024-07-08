<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student_course extends Model
{
    use HasFactory;

    protected $fillable =[
        'student_id',
        'course_id',
        'status',     
    ];

    public function Student()
    {
       return $this->belongsTo(Students::class,'student_id');
    }

    public function Course()
    {
       return $this->belongsTo(Course::class,'course_id');
    }
}
