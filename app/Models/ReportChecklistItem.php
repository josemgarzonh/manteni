<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportChecklistItem extends Model
{
    use HasFactory;

    // Campos que se pueden llenar masivamente
    protected $fillable = [
        'maintenance_report_id',
        'item_nombre',
        'estado',
    ];

    public function maintenanceReport() { return $this->belongsTo(MaintenanceReport::class); }
}