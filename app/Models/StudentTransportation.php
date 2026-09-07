<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTransportation extends Model
{
    use HasFactory;

    protected $table = 'student_transportations';
    protected $fillable = ['student_id', 'route_name', 'pickup_location', 'dropoff_location', 'monthly_fee', 'bus_number', 'academic_year'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
