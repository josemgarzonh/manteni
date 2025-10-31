<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalRound extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'sede_id',
        'servicio_id',
        'zona_id',
        'asset_id',
        'found_failures',
        'failure_description',
        'image_url',
        'observations',
        'responsible_name',
        'responsible_signature',
        'maintenance_request_id',
    ];

    // --- RELACIONES CON OTRAS TABLAS ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }

    public function maintenanceRequest()
    {
        return $this->belongsTo(MaintenanceRequest::class);
    }
}