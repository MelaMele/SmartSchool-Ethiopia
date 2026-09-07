<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;

    protected $table = 'sms_logs';
    protected $fillable = [
        'phone_number',
        'student_id',
        'message',
        'type',
        'status',
        'response_id',
        'sent_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
