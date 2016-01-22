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
        return $this->hasMany('Pedidos\Models\Linea','articulo_id');
    }

}