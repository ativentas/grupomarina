<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{
    
    protected $table = 'plantillas';
    
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'seccion', 'restaurante', 'descripcion',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];


    public function lineas()
    {
        return $this->hasMany('Pedidos\Models\LineaPlantilla','plantilla_id');
    }
}