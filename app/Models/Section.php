<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['section_name', 'class_id', 'stream_id', 'room_number', 'capacity'];

    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function homeRooms()
    {
        return $this->hasMany(HomeRoom::class);
    }
}
