<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable =[
       'name',
       'educational_level',
       'gender',
       'instagram',
       'email', 
       'phone',
       'certificate',
       'personal_photo',
       'identity_photo',     
       'birth_date',
       'about',
    ];

    public function getCertificatePathAttribute()
    {  
        return  "app/public/images/trainer". $this->certificate; 
    }
    public function getPersonal_photoPathAttribute()
    {  
        return  "app/public/images/trainer". $this->personal_photo; 
    }

    public function getIdentity_photoPathAttribute()
    {  
        return  "app/public/images/trainer". $this->identity_photo; 
    }
 
    public function courses()
    {
       return $this->hasMany(Course::class);
    }
}
