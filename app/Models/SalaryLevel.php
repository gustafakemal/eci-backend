<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalaryLevel extends Model
{
    protected $fillable = [
        'level',
        'gaji_min',
        'gaji_max',
    ];
}
