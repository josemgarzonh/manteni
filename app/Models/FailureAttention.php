<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailureAttention extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_request_id',
        'user_id',
        'detalles_tecnicos',
        'estado_falla',
    ];

    /**
     * La solicitud de mantenimiento a la que pertenece esta atención.
     */
    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class);
    }

    /**
     * El técnico que realizó esta atención.
     */
    public function technician()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Las imágenes asociadas a esta atención.
     */
    public function images()
    {
        return $this->hasMany(FailureAttentionImage::class);
    }
}