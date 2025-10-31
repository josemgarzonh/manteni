@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4">Mis Tareas de Mantenimiento Asignadas</h2>
    </div>
    <div class="pb-20">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Solicitud No.</th>
                    <th>Fecha Asignación</th>
                    <th>Equipo/Activo</th>
                    <th>Ubicación</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tasks as $task)
                <tr>
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->updated_at->format('Y-m-d') }}</td>
                    <td>{{ $task->asset->nombre_equipo ?? 'N/A' }}</td>
                    <td>{{ $task->ubicacion_texto }}</td>
                    <td>{{ Str::limit($task->descripcion, 40) }}</td>
                    <td>
                        <a href="{{ route('failures.attend', $task->id) }}" class="btn btn-success btn-sm">
                            Atender Falla
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No tienes tareas asignadas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection