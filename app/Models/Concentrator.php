<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Concentrator extends Model
{
    protected $table = 'Concentrators';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'GENERAL_ID',
        'ACA',
        'DEVICE_FAMILY_ID',
        'PPP_USERNAME',
        'PPP_PWD',
        'LVC_MAA_USERNAME',
        'LVC_MAA_PWD',
        'ETH_RIGHT',
        'MAC_ETH_RIGHT',
        'ETH_LEFT',
        'MAC_ETH_LEFT',
        
    ];

    public $timestamps = false;

    public function general()
    {
        return $this->belongsTo(General::class, 'GENERAL_ID');
    }

    public function deviceFamily()
    {
        return $this->belongsTo(DeviceType::class, 'DEVICE_FAMILY_ID');
    }

    public function deviceCTypology()
    {
        return $this->belongsTo(DeviceType::class, 'TYPOLOGY_ID');
    }

    public function user()
    {
        return $this->belongsTo(General::class);
    }
}
