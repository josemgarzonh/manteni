
@extends('layouts.app')

@section('title', 'Lista de Actividades Programadas')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Actividades Programadas</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('schedules.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nueva Actividad
            </a>
            <a href="{{ route('schedules.calendar') }}" class="btn btn-outline-primary">
                <i class="fas fa-calendar"></i> Ver Calendario
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('schedules.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label class="form-label">Tipo</label>
                        <select class="form-select" name="type">
                            <option value="">Todos los tipos</option>
                            <option value="hospital_round" {{ request('type') == 'hospital_round' ? 'selected' : '' }}>Ronda Hospitalaria</option>
                            <option value="defibrillator_test" {{ request('type') == 'defibrillator_test' ? 'selected' : '' }}>Test Desfibrilador</option>
                            <option value="preventive_maintenance" {{ request('type') == 'preventive_maintenance' ? 'selected' : '' }}>Mantenimiento</option>
                            <option value="calibration" {{ request('type') == 'calibration' ? 'selected' : '' }}>Calibración</option>
                            <option value="training" {{ request('type') == 'training' ? 'selected' : '' }}>Capacitación</option>
                            <option value="intervention" {{ request('type') == 'intervention' ? 'selected' : '' }}>Intervención</option>
                            <option value="failure_attention" {{ request('type') == 'failure_attention' ? 'selected' : '' }}>Atención de Falla</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sede</label>
                        <select class="form-select" name="sede_id">
                            <option value="">Todas las sedes</option>
                            @foreach($sedes as $sede)
                                <option value="{{ $sede->id }}" {{ request('sede_id') == $sede->id ? 'selected' : '' }}>
                                    {{ $sede->nombre_sede }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="status">
                            <option value="">Todos los estados</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completado</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Filtrar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de actividades -->
    <div class="card">
        <div class="card-body">
            @if($activities->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Tipo</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Asignado a</th>
                                <th>Prioridad</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($activities as $activity)
                            <tr>
                                <td>{{ $activity->title }}</td>
                                <td>
                                    <span class="badge bg-{{ $activity->type_badge }}">
                                        {{ $activity->activity_type_label }}
                                    </span>
                                </td>
                                <td>{{ $activity->start_date->format('d/m/Y H:i') }}</td>
                                <td>{{ $activity->end_date->format('d/m/Y H:i') }}</td>
                                <td>{{ $activity->assignedUser->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $activity->priority_class }}">
                                        {{ ucfirst($activity->priority) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($activity->status == 'completed') bg-success
                                        @elseif($activity->status == 'in_progress') bg-primary
                                        @elseif($activity->status == 'cancelled') bg-secondary
                                        @else bg-warning @endif">
                                        {{ ucfirst($activity->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('schedules.show', $activity) }}" 
                                           class="btn btn-outline-info" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('schedules.edit', $activity) }}" 
                                           class="btn btn-outline-primary" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('schedules.destroy', $activity) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" 
                                                    onclick="return confirm('¿Estás seguro de eliminar esta actividad?')"
                                                    title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $activities->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5>No hay actividades programadas</h5>
                    <p class="text-muted">Comienza creando una nueva actividad programada.</p>
                    <a href="{{ route('schedules.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Crear Primera Actividad
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection