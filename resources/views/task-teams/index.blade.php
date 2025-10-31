@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4 float-left">Gestionar Equipos de Tarea</h2>
        <a href="{{ route('task-teams.create') }}" class="btn btn-primary float-right">Crear Nuevo Equipo</a>
    </div>
    <div class="pb-20">
        @if (session('success'))
            <div class="alert alert-success mx-4">{{ session('success') }}</div>
        @endif
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre del Equipo</th>
                    <th>Miembros</th>
                    <th>Zonas Asignadas</th>
                    <th>Servicios Asignados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($taskTeams as $team)
                <tr>
                    <td>{{ $team->nombre_equipo }}</td>
                    <td>
                        @foreach($team->users as $user)
                            <span class="badge badge-secondary">{{ $user->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach($team->zonas as $zona)
                            <span class="badge badge-info">{{ $zona->nombre_zona }}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach($team->services as $service)
                            <span class="badge badge-light">{{ $service->nombre_servicio }}</span>
                        @endforeach
                    </td>
                    <td>
                        <a href="{{ route('task-teams.edit', $team->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        <form action="{{ route('task-teams.destroy', $team->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No hay equipos de tarea registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection