<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
  
    protected $table = 'providers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comentarios', 'contacto', 'tel_contacto'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function pedidos()
    {
        return $this->hasMany('Pedidos\Models\Pedido', 'provider_id');
    }


}