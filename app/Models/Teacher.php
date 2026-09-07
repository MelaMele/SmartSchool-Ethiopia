<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'field_of_study',
        'place_of_study',
        'teacher_training_institute',
        'debut_as_a_teacher',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function homeRooms()
    {
        return $this->hasMany(HomeRoom::class, 'teacher_id');
    }

    public function courseLoads()
    {
        return $this->hasMany(CourseLoad::class, 'teacher_id');
    }
}
