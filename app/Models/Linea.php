<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class Linea extends Model
{
  
    protected $table = 'lineas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['pedido_id','article_id','precio','cantidad','recibido'
    
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function pedido()
    {
        return $this->belongsTo('Pedidos\Models\Pedido', 'pedido_id');
    }

    public function articulo()
    {
        return $this->belongsTo('Pedidos\Models\Articulo', 'article_id');
    }


}