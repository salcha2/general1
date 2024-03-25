<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'Companies';

    protected $fillable = [
        'COMPANY',
    ];

    public $timestamps = false;

}
