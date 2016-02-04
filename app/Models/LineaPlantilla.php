<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class LineaPlantilla extends Model
{
    
    protected $table = 'lineasPlantillas';
    
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'plantilla_id', 'articulo_codint','talla','color',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function plantilla()
    {
        return $this->belongsTo('Pedidos\Models\Plantilla', 'plantilla_id');
    }

    public function articulo()
    {
        return $this->belongsTo('Pedidos\Models\Articulo', 'articulo_codint', 'codigo_interno');
    }

}