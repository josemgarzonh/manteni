@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4 float-left">Gestionar Roles</h2>
        <a href="{{ route('roles.create') }}" class="btn btn-primary float-right">Añadir Nuevo Rol</a>
    </div>
    <div class="pb-20">
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>Nombre del Rol</th><th>Permisos</th><th>Acciones</th></tr></thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->nombre_rol }}</td>
                    <td>
                        @foreach($role->permissions as $permission)
                            <span class="badge badge-secondary">{{ $permission->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        {{-- Aquí iría el formulario de borrado --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection