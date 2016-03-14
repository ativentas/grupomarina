<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public function empleado()
    {
        return $this->belongsTo('Pedidos\Models\User', 'empleado_id');
    }
}
