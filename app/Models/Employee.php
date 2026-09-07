<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'birth_date',
        'hired_date',
        'photo',
        'education_status',
        'marriage_status',
        'net_salary',
        'hire_type',
        'role_id',
        'employee_job_position_id',
        'address_id',
        'user_id',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }

    public function position()
    {
        return $this->belongsTo(EmployeeJobPosition::class, 'employee_job_position_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'employee_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
