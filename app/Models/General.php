<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    protected $table = 'General';

    protected $primaryKey = 'ID';


    protected $fillable = [
        'DEVICE_ID',
        'NAME',
        'SERIAL_NUMBER',
        'RECEPTION_DATE',
        'ORIGIN',
        'RECIPIENT',
        'STATE_ID',
        'LOCATION',
        'OWNER',
        'QUANTITY',
        'NOTES',
        'INSERTION_DATE',
        'INSERTED_BY',
        'MODIFICATION_DATE',
        'MODIFIED_BY',
        'VERSION',
        'VISIBLE',
    ];

    // Indica a Eloquent que las columnas created_at y updated_at existen
    public $timestamps = true;

    public function device()
    {
        return $this->belongsTo(DeviceType::class, 'DEVICE_ID');
    }


   


    public function originEntity()
    {
        return $this->belongsTo(Entity::class, 'ORIGIN');
    }

    public function recipientAdminUser()
    {
        return $this->belongsTo(AdminUser::class, 'RECIPIENT');
    }

    public function state()
    {
        return $this->belongsTo(Status::class, 'STATE_ID');
    }

    public function ownerEntity()
    {
        return $this->belongsTo(Entity::class, 'OWNER');
    }

    public function insertedByAdminUser()
    {
        return $this->belongsTo(AdminUser::class, 'INSERTED_BY');
    }

    public function modifiedByAdminUser()
    {
        return $this->belongsTo(AdminUser::class, 'MODIFIED_BY');
    }
}