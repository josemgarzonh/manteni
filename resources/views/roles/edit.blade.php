@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Editar Rol: {{ $role->nombre_rol }}</h2>
    <div class="pd-20">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nombre del Rol</label>
                <input class="form-control" type="text" name="nombre_rol" value="{{ $role->nombre_rol }}" required>
            </div>

            <h5 class="h5 mt-4">Asignar Permisos</h5>
            <div class="form-group">
                @foreach($permissions as $permission)
                    <div class="custom-control custom-checkbox mb-5">
                        <input type="checkbox" class="custom-control-input" id="perm_{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}"
                            {{ $role->permissions->contains($permission) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="perm_{{ $permission->id }}">{{ $permission->name }}</label>
                    </div>
                @endforeach
            </div>

            <div class="text-right">
                <a href="{{ route('roles.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Rol</button>
            </div>
        </form>
    </div>
</div>
@endsection