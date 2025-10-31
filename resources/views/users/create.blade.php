@extends('layouts.app')

@section('content')

<div class="card-box mb-30">
    <h2 class="h4 pd-20">Crear Nuevo Usuario</h2>
    <div class="pd-20">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf  {{-- Token de seguridad de Laravel, ¡muy importante! --}}

            <div class="form-group">
                <label>Nombre</label>
                <input class="form-control" type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input class="form-control" type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Cédula</label>
                <input class="form-control" type="text" name="cedula">
            </div>
            <div class="form-group">
                <label>Celular</label>
                <input class="form-control" type="text" name="celular">
            </div>
            <div class="form-group">
                <label>Rol</label>
                <select class="form-control" name="rol_id" required>
                    <option value="" disabled selected>Selecciona un rol</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->nombre_rol }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Contraseña</label>
                <input class="form-control" type="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Usuario</button>
        </form>
    </div>
</div>

@endsection