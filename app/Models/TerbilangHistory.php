<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class TerbilangHistory extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'terbilang_histories';

    protected $fillable = [
        'angka',
        'hasil',
    ];
}
