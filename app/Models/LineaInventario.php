<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class LineaInventario extends Model
{
  
    protected $table = 'lineasInventarios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['inventario_id','articulo_codint','unidades','cod_barras'

    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function inventario()
    {
        return $this->belongsTo('Pedidos\Models\Inventario', 'inventario_id');
    }

    public function articulo()
    {
        return $this->belongsTo('Pedidos\Models\Articulo', 'articulo_codint', 'codigo_interno');
    }


}