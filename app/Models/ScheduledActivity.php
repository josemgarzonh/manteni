<?php
// app/Models/ScheduledActivity.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'activity_type', 'start_date', 'end_date',
        'status', 'priority', 'asset_id', 'assigned_to', 'created_by',
        'sede_id', 'servicio_id', 'zone_id', 'recurrence', 'recurrence_end_date'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'recurrence_end_date' => 'datetime',
    ];

    // Relaciones
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function zone()
    {
        return $this->belongsTo(Zona::class);
    }

    public function reminders()
    {
        return $this->hasMany(ActivityReminder::class);
    }

    // Scopes para filtros
    public function scopeType($query, $type)
    {
        return $query->where('activity_type', $type);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now());
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    // Accessors
    public function getActivityTypeLabelAttribute()
    {
        return match($this->activity_type) {
            'hospital_round' => 'Ronda Hospitalaria',
            'defibrillator_test' => 'Test Desfibrilador',
            'preventive_maintenance' => 'Mantenimiento Preventivo',
            'calibration' => 'Calibración',
            'training' => 'Capacitación',
            'intervention' => 'Intervención',
            'failure_attention' => 'Atención de Falla',
            default => $this->activity_type
        };
    }

    public function getPriorityClassAttribute()
    {
        return match($this->priority) {
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            'urgent' => 'dark',
            default => 'secondary'
        };
    }

    public function getTypeBadgeAttribute()
    {
        return match($this->activity_type) {
            'hospital_round' => 'primary',
            'defibrillator_test' => 'success',
            'preventive_maintenance' => 'warning',
            'calibration' => 'info',
            'training' => 'purple',
            'intervention' => 'danger',
            'failure_attention' => 'dark',
            default => 'secondary'
        };
    }
}