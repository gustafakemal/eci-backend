<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class BintangHistory extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'bintang_histories';

    protected $fillable = [
        'jumlah',
        'tipe',
        'pola',
    ];
}
