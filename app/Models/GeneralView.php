<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralView extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'general_view';


    protected $primaryKey = 'ID';


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ID', 'device_type', 'entity', 'company', 'state', 'reciver', 'inserted_B', 'modified_B', 'VERSION'
        // Agrega aquí otros campos que sean asignables por lotes (mass assignable)
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        // Define aquí los nombres de las columnas que están protegidas
        // contra la asignación masiva (mass assignment) si es necesario.
    ];

    /**
     * Define las relaciones si es necesario.
     */
    // Aquí puedes definir relaciones si hay alguna definida en la vista

    /**
     * Casts for model attributes.
     *
     * @var array
     */
    protected $casts = [
        // Define aquí los atributos que deben ser convertidos a tipos de datos específicos
    ];
}
