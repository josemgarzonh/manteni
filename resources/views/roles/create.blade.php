@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Añadir Nuevo Rol</h2>
    <div class="pd-20">
        <form action="{{ route('roles.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nombre del Rol</label>
                <input class="form-control" type="text" name="nombre_rol" required>
            </div>
            <div class="text-right">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Rol</button>
            </div>
        </form>
    </div>
</div>
@endsection