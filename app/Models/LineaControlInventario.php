<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class LineaControlInventario extends Model
{
    

	protected $table = 'lineasControlInventarios';

    public function control()
    {
    	$this->belongsTo('Pedidos\Models\ControlInventario','controlInventarios_id');
    }

    public function articulo()
    {
        return $this->belongsTo('Pedidos\Models\Articulo', 'codigoArticulo_id', 'codigo_interno');
    }
}
