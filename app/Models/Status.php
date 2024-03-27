<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'Status';

    protected $fillable = [
        'STATE',
        'DESCRIPTION',
    ];

    public $timestamps = false;


    public function statuses()
{
    return $this->hasMany(Status::class, 'STATE_ID');
}
}
