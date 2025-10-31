<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    public function sede()
        {
            return $this->belongsTo(Sede::class);
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
