<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    protected $table = 'Entities';

    protected $fillable = [
        'ENTITY',
        'COMPANY',
    ];

    public $timestamps = false;

}
