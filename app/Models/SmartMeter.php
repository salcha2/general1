<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmartMeter extends Model
{
    protected $table = 'SmartMeters';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'GENERAL_ID',
        'ACA',
        'DEVICE_FAMILY_ID',
        'KW_CE',
        'KR_CE',
        'COMMUNICATION_ENC_RF_KEY',
        'COMMISSIONING_ENC_RF_KEY',
        'COMMUNICATION_AUTH_RF_KEY',
        'COMMISSIONING_AUTH_RF_KEY',
        'RF_MASTER_KEY',
        
        
    ];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        // Agregar un evento "creating" para verificar el valor de DEVICE_FAMILY_ID antes de la inserción
        static::creating(function ($model) {
            if (is_null($model->DEVICE_FAMILY_ID)) {
                return false; // Cancelar la inserción si DEVICE_FAMILY_ID es nulo
            }
        });
    }

    public function general()
    {
        return $this->belongsTo(General::class, 'GENERAL_ID');
    }

    public function deviceFamily()
    {
        return $this->belongsTo(DeviceType::class, 'DEVICE_FAMILY_ID');
    }

    public function deviceTypology()
    {
        return $this->belongsTo(DeviceType::class, 'TYPOLOGY_ID');
    }

    


    public function user()
    {
        return $this->belongsTo(General::class);
    }
}
