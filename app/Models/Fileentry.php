<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class Fileentry extends Model
{
    public function user()
    {
        return $this->belongsTo('Pedidos\Models\User', 'user_id');
    }
}
