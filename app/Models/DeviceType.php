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
    public function generals()
    {
        return $this->hasMany(General::class, 'DEVICE_ID');
    }

    public function smooth()
    {
        return $this->hasOne(DeviceType::class, 'DEVICE_TYPE_ID');
    }

    

}



