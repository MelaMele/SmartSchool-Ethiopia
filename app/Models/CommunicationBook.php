<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationBook extends Model
{
    use HasFactory;

    protected $table = 'communication_books';
    protected $fillable = [
        'student_id',
        'teacher_id',
        'date',
        'type',
        'title',
        'message',
        'parent_reply',
        'is_acknowledged',
        'acknowledged_at',
    ];

    protected $casts = [
        'is_acknowledged' => 'boolean',
        'acknowledged_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
