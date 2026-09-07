<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLoad extends Model
{
    use HasFactory;

    protected $table = 'payment_loads';
    protected $fillable = ['class_id', 'payment_type_id', 'amount', 'academic_year'];

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id');
    }
}
