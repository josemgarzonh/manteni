@extends('layouts.app')

@section('content')

<div class="card-box mb-30">
    <h2 class="h4 pd-20">Editar Usuario: {{ $user->name }}</h2>
    <div class="pd-20">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf  {{-- Token de seguridad --}}
            @method('PUT') {{-- Método para indicar que es una actualización --}}

            <div class="form-group">
                <label>Nombre</label>
                <input class="form-control" type="text" name="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" type="email" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label>Cédula</label>
                <input class="form-control" type="text" name="cedula" value="{{ $user->cedula }}">
            </div>
            <div class="form-group">
                <label>Celular</label>
                <input class="form-control" type="text" name="celular" value="{{ $user->celular }}">
            </div>
            <div class="form-group">
                <label>Rol</label>
                <select class="form-control" name="rol_id" required>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->rol_id == $role->id ? 'selected' : '' }}>
                            {{ $role->nombre_rol }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Nueva Contraseña (opcional)</label>
                <input class="form-control" type="password" name="password">
                <small class="form-text text-muted">Dejar en blanco para no cambiar la contraseña.</small>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
        </form>
    </div>
</div>

@endsection