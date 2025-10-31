<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',
        'cedula',
        'celular',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    /**
     * Obtener el rol asociado al usuario.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id');
    }

    /**
     * Comprueba si el usuario tiene un permiso específico a través de su rol.
     *
     * @param string $permissionName El nombre del permiso a comprobar.
     * @return bool
     */
    public function hasPermission(string $permissionName): bool
    {
        // El Super Administrador (rol_id = 1) siempre tiene todos los permisos.
        if ($this->rol_id == 1) {
            return true;
        }

        // Carga la relación de rol con sus permisos si aún no se ha cargado.
        $this->loadMissing('role.permissions');

        // Comprueba si el usuario tiene un rol y si ese rol tiene el permiso.
        return $this->role && $this->role->permissions->contains('name', $permissionName);
    }
}


