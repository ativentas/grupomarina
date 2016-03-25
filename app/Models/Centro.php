<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class Centro extends Model
{
    
	protected $table = 'centros';

    public function empleados()
    {
    	return $this->belongstoMany('Pedidos\Models\User');
    }
    
    public function trabajadores()
    {
    	return $this->hasMany('Pedidos\Models\User','restaurante_id');
    }
    public function trabajadoresAlta()
    {
    	return $this->hasMany('Pedidos\Models\User','empresa_id');

    }
}
