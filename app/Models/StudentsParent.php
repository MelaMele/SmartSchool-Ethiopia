<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsParent extends Model
{
    use HasFactory;

    protected $table = 'students_parents';
    protected $fillable = [
        'student_id',
        'father_name',
        'father_phone',
        'father_occupation',
        'mother_name',
        'mother_phone',
        'mother_occupation',
        'guardian_name',
        'guardian_phone',
        'guardian_relation',
        'user_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
