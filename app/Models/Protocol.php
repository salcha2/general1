<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    protected $table = 'Protocols';

    protected $fillable = [
        'APPLICATION_PROTOCOL',
        'PHYSICAL_PROTOCOL',
    ];

    public $timestamps = false;

    // Relación: Un protocolo puede ser utilizado por muchos generales (General)
    public function generals()
    {
        return $this->hasMany(General::class, 'APPLICATION_PROTOCOL_ID');
    }

    // Relación: Un protocolo puede ser utilizado por muchos generales (General)
    public function generales()
    {
        return $this->hasMany(General::class, 'PHYSICAL_PROTOCOL_ID');
    }
}
