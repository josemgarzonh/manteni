<?php
// app/Models/ActivityReminder.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'scheduled_activity_id', 'remind_minutes_before', 'sent'
    ];

    protected $casts = [
        'sent' => 'boolean',
    ];

    public function activity()
    {
        return $this->belongsTo(ScheduledActivity::class, 'scheduled_activity_id');
    }
}