<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['subject_name', 'subject_code', 'description'];

    public function markLists()
    {
        return $this->hasMany(StudentMarkList::class);
    }

    public function courseLoads()
    {
        return $this->hasMany(CourseLoad::class);
    }
}
