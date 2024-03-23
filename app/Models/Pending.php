<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pending extends Model
{
    protected $table = 'Pending';

    protected $primaryKey = 'ID';

    protected $fillable = [
        'DEVICE_TYPE_ID',
        'QUANTITY',
        'DETAILS',
        'STATE_ID',
        'GENERAL_ID',
        'ENTITY_ID',
    ];

    public function deviceType()
    {
        return $this->belongsTo(DeviceType::class, 'DEVICE_TYPE_ID');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'STATE_ID');
    }

    // public function general()
    // {
    //     return $this->belongsTo(General::class, 'GENERAL_ID');
    // }

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'ENTITY_ID');
    }

    public function smarto()
    {
        return $this->belongsTo(General::class);
    }
}
