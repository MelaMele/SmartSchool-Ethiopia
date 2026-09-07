<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'birth_date',
        'photo',
        'class_id',
        'stream_id',
        'section_id',
        'address_id',
        'user_id',
        'status',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->hasOne(StudentsParent::class, 'student_id');
    }

    public function markLists()
    {
        return $this->hasMany(StudentMarkList::class, 'student_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function payments()
    {
        return $this->hasMany(StudentPayment::class, 'student_id');
    }

    public function discounts()
    {
        return $this->hasMany(StudentDiscount::class, 'student_id');
    }

    public function transportation()
    {
        return $this->hasOne(StudentTransportation::class, 'student_id');
    }
}
