<?php

namespace Pedidos\Models;


use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'nombre_completo', 'restaurante', 'active', 'is_admin', 'is_supervisor',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    
    public function scopeNoAdmin($query)
    {
        return $query->where('is_admin',false)->where('active', true);
    }

    public function pedidos()
    {
        return $this->hasMany('Pedidos\Models\Pedido', 'user_id');
    }

    public function lineas()
    {
        return $this->hasMany('Pedidos\Models\Linea', 'user_id');
    }

    public function isAdmin()
    {
        return (bool) $this->is_admin;
    }

    public function isSupervisor()
    {
        return (bool) $this->is_supervisor;
    }


}
