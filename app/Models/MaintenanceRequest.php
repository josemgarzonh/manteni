<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'asset_id',
        'solicitante_nombre',
        'ubicacion_texto',
        'descripcion',
        'imagen_url',
        'estado',
        'assigned_to', // Asegúrate de que este campo esté aquí
        'attended_at', // Y este también
        'estado_falla', // Y este
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
    
    // --- FUNCIÓN A AÑADIR ---
    /**
     * Obtiene el historial de atenciones para esta solicitud de mantenimiento.
     */
    public function attentions()
    {
        return $this->hasMany(FailureAttention::class);
    }
    // --- FIN DE LA FUNCIÓN A AÑADIR ---
}