<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparePartRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'maintenance_report_id',
        'user_id',
        'asset_id',
        'part_name',
        'quantity',
        'photo_url',
        'status',
    ];

    public function maintenanceReport()
    {
        return $this->belongsTo(MaintenanceReport::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}

