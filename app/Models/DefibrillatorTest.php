<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefibrillatorTest extends Model
{
    use HasFactory;

    protected $guarded = []; // Permitir asignación masiva

    public function asset() { return $this->belongsTo(Asset::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function servicio() { return $this->belongsTo(Servicio::class); }
    // ... (dentro de la clase DefibrillatorTest)
    public function images()
    {
        return $this->hasMany(DefibrillatorTestImage::class);
    }
}