<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTeam extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_equipo'];

    /**
     * Relación muchos a muchos con Usuarios (Técnicos/Ingenieros).
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'task_team_user');
    }

    /**
     * Relación muchos a muchos con Zonas.
     */
    public function zonas()
    {
        return $this->belongsToMany(Zona::class, 'task_team_zone');
    }

   // --- NUEVA RELACIÓN ---
    public function sedes()
    {
        return $this->belongsToMany(Sede::class, 'task_team_sede');
    }

    // --- RELACIÓN CORREGIDA ---
    public function services()
    {
        // Especificamos la clave foránea correcta ('service_id') que creaste en la migración.
        return $this->belongsToMany(Servicio::class, 'task_team_service', 'task_team_id', 'service_id');
    }
}