<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeJobPosition extends Model
{
    use HasFactory;

    protected $fillable = ['position_title', 'description'];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
