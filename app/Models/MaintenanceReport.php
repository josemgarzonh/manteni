<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'tecnico_id',
        'tipo_mantenimiento',
        'tiempo_ejecucion_horas',
        'observaciones',
        'repuestos_utilizados',
        'recibe_nombre',
        'recibe_cargo',
        'firma_tecnico_url',
        'firma_recibe_url',
    ];

    public function asset() { return $this->belongsTo(Asset::class); }
    public function tecnico() { return $this->belongsTo(User::class, 'tecnico_id'); }
    public function checklistItems() { return $this->hasMany(ReportChecklistItem::class); }
    
    // AÑADIR ESTA LÍNEA
    public function sparePartRequests() { return $this->hasMany(SparePartRequest::class); }
}
