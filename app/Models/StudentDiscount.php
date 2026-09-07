<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDiscount extends Model
{
    use HasFactory;

    protected $table = 'student_discounts';
    protected $fillable = ['student_id', 'payment_type_id', 'discount_percentage', 'reason', 'academic_year'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }
}
