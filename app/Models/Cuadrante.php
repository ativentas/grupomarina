<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class Cuadrante extends Model
{
    
	protected $table = 'cuadrantes';

    public function lineas()
    {
    	return 	$this->hasMany('Pedidos\Models\LineaCuadrante','cuadrante_id');
    }

    public function getDates()
{
    return ['created_at','updated_at','fecha'];
}

}