<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentMarkList extends Model
{
    use HasFactory;

    protected $table = 'student_mark_lists';
    protected $fillable = [
        'student_id',
        'class_id',
        'section_id',
        'subject_id',
        'semister_id',
        'assasment_type_id',
        'mark',
        'load',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function semister()
    {
        return $this->belongsTo(Semister::class, 'semister_id');
    }

    public function assessmentType()
    {
        return $this->belongsTo(AssasmentType::class, 'assasment_type_id');
    }
}
