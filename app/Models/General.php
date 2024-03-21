<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class General extends Model
{

    use SoftDeletes;

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
        'url' 
    ];

    // Indica a Eloquent que las columnas created_at y updated_at existen
    public $timestamps = true;


    protected $dates = ['DELETED_AT'];


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


    public function profile()
    {
        return $this->hasOne(SmartMeter::class, 'GENERAL_ID');
    }

    public function smart()
    {
        return $this->hasOne(Concentrator::class, 'GENERAL_ID');
    }

    //  public function stado()
    //  {
    //      return $this->hasOne(Status::class, 'ID');
    //  }

    


    public function generales()
    {
        return $this->belongsTo(General::class, 'DEVICE_TYPE_ID');
    }


    
}