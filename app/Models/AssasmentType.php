<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssasmentType extends Model
{
    use HasFactory;

    protected $table = 'assasment_types';
    protected $fillable = ['assasment_type', 'max_mark', 'weight'];

    public function markLists()
    {
        return $this->hasMany(StudentMarkList::class, 'assasment_type_id');
    }
}
