<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semister extends Model
{
    use HasFactory;

    protected $table = 'semisters';
    protected $fillable = ['semister_name', 'academic_year', 'is_current', 'start_date', 'end_date'];

    protected $casts = [
        'is_current' => 'boolean',
    ];

    public function markLists()
    {
        return $this->hasMany(StudentMarkList::class, 'semister_id');
    }
}
