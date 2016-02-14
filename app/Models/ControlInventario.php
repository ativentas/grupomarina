<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class ControlInventario extends Model
{
	
	protected $table = 'controlInventarios';
    public function lineas()
    {
        return $this->hasMany('Pedidos\Models\LineaControlInventario', 'controlInventarios_id');
    }
}