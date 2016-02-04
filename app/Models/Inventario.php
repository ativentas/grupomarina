<?php

namespace Pedidos\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    
    protected $table = 'inventarios';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'seccion', 'restaurante', 'estado',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    public function user()
    {
        return $this->belongsTo('Pedidos\Models\User', 'user_id');
    }

    public function lineas()
    {
        return $this->hasMany('Pedidos\Models\LineaInventario','inventario_id');
    }



}