<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $table = 'courses';
    protected $fillable =[
       'category_id',
       'trainer_id',
       'name',
       'description',
       'age', 
       'number_of_students',
       'number_of_students_paid',
       'price',
       'number_of_sessions',
       'start_date',     
       'end_date',
       'time',
       'photo',
       'status',
    ];

    public function getPhotoPathAttribute()
    {  
        return  "app/public/images/". $this->photo; 
    }
 
    public function category()
    {
       return $this->belongsTo(Category::class,'category_id');
    }

    public function trainer()
    {
       return $this->belongsTo(Trainer::class,'trainer_id');
    }

    public function StudentCourses()
    {
       return $this->hasMany(Student_course::class);
    }
}
