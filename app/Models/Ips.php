<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ips extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre_prestador',
        'nit',
        'direccion',
        'telefono',
        'email',
        'razon_social',
    ];

    public function sedes()
    {
        return $this->hasMany(Sede::class);
    }
}