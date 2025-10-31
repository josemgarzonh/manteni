<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;

    protected $fillable = [
        'ips_id',
        'nombre_sede',
        'zona',
        'direccion',
        'telefono',
    ];

    public function ips()
    {
        return $this->belongsTo(Ips::class);
    }

    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
    
    public function zonas()
    {
        return $this->hasMany(Zona::class);
    }
}

