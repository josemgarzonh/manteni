<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    use HasFactory;

    protected $fillable = ['sede_id', 'servicio_id', 'nombre_zona'];

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }    
}
