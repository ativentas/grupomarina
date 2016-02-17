<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
  
    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function proveedor()
    {
        return $this->belongsTo('Pedidos\Models\Proveedor', 'provider_id');
    }

    public function lineas()
    {
        return $this->hasMany('Pedidos\Models\Linea','article_id');
    }

    public function lineasPlantilla()
    {
        return $this->hasMany('Pedidos\Models\LineaPlantilla', 'articulo_codint', 'codigo_interno');
    }

    public function lineasControlInventario()
    {
        return $this->hasMany('Pedidos\Models\LineaControlInventario', 'codigoArticulo_id', 'codigo_interno');
    }

}