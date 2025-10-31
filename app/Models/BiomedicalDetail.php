<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BiomedicalDetail extends Model
{
    use HasFactory;

    // Le decimos a Laravel que el primary key no es 'id' sino 'asset_id'
    protected $primaryKey = 'asset_id';

    public $incrementing = false;

    // Permitimos que estos campos se guarden masivamente
    protected $fillable = [
        'asset_id',
        'clasificacion_riesgo',
        'clasificacion_uso',
        'tecnologia_predominante',
        'fabricante',
        'fecha_fabricacion',
        'correo_fabricante',
        'contacto_fabricante',
        'forma_adquisicion',
        'proveedor_nombre',
        'costo_adquisicion',
        'vida_util',
        'garantia_inicio',
        'garantia_fin',
        'registro_invima',
        'componentes_accesorios',
        'rango_voltaje',
        'rango_corriente',
        'rango_potencia',
        'rango_frecuencia',
        'rango_presion',
        'rango_temperatura',
        'rango_humedad',
        'peso',
        'indicaciones_fabricante'
    ];
}

