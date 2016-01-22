<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    
    protected $table = 'pedidos';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id', 'user_id', 'restaurante', 'estado', 'comentarios'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];
    
    public function scopeAbiertos($query)
    {
        return $query->where('estado', 'Abierto');
    }
    
    public function scopeCerrados($query)
    {
        return $query->where('estado', 'Lanzado');
    }

    public function user()
    {
        return $this->belongsTo('Pedidos\Models\User', 'user_id');
    }

    public function proveedor()
    {
        return $this->belongsTo('Pedidos\Models\Proveedor', 'provider_id');
    }

    public function lineas()
    {
        return $this->hasMany('Pedidos\Models\Linea', 'pedido_id');
    }
}