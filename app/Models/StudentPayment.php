<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    use HasFactory;

    protected $table = 'student_payments';
    protected $fillable = [
        'student_id',
        'payment_type_id',
        'amount_paid',
        'fs_number',
        'ethiopian_month',
        'payment_date',
        'payment_method',
        'received_by',
        'remark',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
