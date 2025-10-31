<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function assetType()
    {
        return $this->belongsTo(AssetType::class);
    }

    public function sede()
    {
        return $this->belongsTo(Sede::class);
    }

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
    
    public function maintenanceReports()
            {
                return $this->hasMany(MaintenanceReport::class);
            }
            
    public function biomedicalDetail()
            {
                return $this->hasOne(BiomedicalDetail::class);
            }        
}
