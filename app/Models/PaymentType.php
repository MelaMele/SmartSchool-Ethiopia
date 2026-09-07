<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = ['payment_type_name', 'description'];

    public function paymentLoads()
    {
        return $this->hasMany(PaymentLoad::class);
    }

    public function payments()
    {
        return $this->hasMany(StudentPayment::class);
    }
}
