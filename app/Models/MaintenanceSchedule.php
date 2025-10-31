<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'task',
        'frequency_days',
        'next_due_date',
        'status',
    ];

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}