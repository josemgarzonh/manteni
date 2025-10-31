<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_rol'];

    public function users()
    {
        return $this->hasMany(User::class, 'rol_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}