<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    protected $table = 'DeviceType';

    protected $fillable = [
        'DEVICE_TYPE',
        'TYPOLOGY',
        'APPLICATION_PROTOCOL',
        'PHYSICAL_PROTOCOL',
        'RADIO_INTERFACE',
        'FAMILY_SM',
        'FAMILY_LVC',
    ];

    public $timestamps = false;


}



