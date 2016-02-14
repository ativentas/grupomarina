<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class LineaControlInventario extends Model
{
    

	protected $table = 'lineasControlInventarios';

    public function control()
    {
    	$this->belongsTo('ControlInventario','controlInventarios_id');
    }
}
