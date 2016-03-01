<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class LineaCuadrante extends Model
{
    
	protected $table = 'lineasCuadrantes';

    public function cuadrante()
    {
    	return $this->belongsTo('Pedidos\Models\Cuadrante','cuadrante_id');
    }

    public function empleado()
    {
        return $this->belongsTo('Pedidos\Models\User', 'empleado_id');
    }
}