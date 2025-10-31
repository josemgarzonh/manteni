<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    /**
     * Los roles que tienen este permiso.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}