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
        'username', 'email', 'password', 'nombre_completo', 'restaurante_id', 'empresa_id','entrada','salida','active', 'is_admin', 'is_supervisor', 'entrada2', 'salida2', 'turno_partido',
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
    public function scopeNoRoot($query)
    {
        return $query->where('is_root',false)->where('active', true);
    }
    
    public function scopeAdministradores($query)
    {
        return $query->where('is_admin',true)->where('active', true);
    }   
    public function pedidos()
    {
        return $this->hasMany('Pedidos\Models\Pedido', 'user_id');
    }
    public function lineas()
    {
        return $this->hasMany('Pedidos\Models\Linea', 'user_id');
    }   
    public function fileentries()
    {
        return $this->hasMany('Pedidos\Models\Fileentry', 'user_id');
    }
    public function isAdmin()
    {
        return (bool) $this->is_admin;
    }    
    public function isRoot()
    {
        return (bool) $this->is_root;
    }
    public function isSupervisor()
    {
        return (bool) $this->is_supervisor;
    }    
    public function lineascuadrantes()
    {
        return $this->hasMany('Pedidos\Models\LineaCuadrante','empleado_id');
    }
    public function eventos()
    {
        return $this->hasMany('Pedidos\Models\Event','empleado_id');
    }
    public function centros()
    {
        return $this->belongsToMany('Pedidos\Models\Centro');
    }
    public function restaurante()
    {
        return $this->belongsTo('Pedidos\Models\Centro', 'restaurante_id');
    }    
    public function empresa()
    {
        return $this->belongsTo('Pedidos\Models\Centro', 'empresa_id');
    }
}
