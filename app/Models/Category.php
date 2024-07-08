<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'photo',
        'description',
    ];
    
    public function getPhotoPathAttribute()
    {  
        return  "app/public/images/". $this->photo; // Adjust this to your actual path logic
    }
    
    public function courses()
    {
       return $this->hasMany(Course::class);
    }
}
