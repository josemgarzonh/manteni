@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Tarjetas de estadísticas -->
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <div id="chart"></div>
                        </div>
                        <div class="ridget-data">
                            <div class="hs mb-2">{{ $stats['asset_count'] ?? 0 }}</div>
                            <div class="weight-499 font-14">Equipos Totales</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <div id="chart2"></div>
                        </div>
                        <div class="ridget-data">
                            <div class="hs mb-2">{{ $stats['pending_activities'] ?? 0 }}</div>
                            <div class="weight-499 font-14">Actividades Pendientes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <div id="chart3"></div>
                        </div>
                        <div class="ridget-data">
                            <div class="hs mb-2">{{ $stats['urgent_activities'] ?? 0 }}</div>
                            <div class="weight-499 font-14">Actividades Urgentes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <div id="chart4"></div>
                        </div>
                        <div class="ridget-data">
                            <div class="hs mb-2">{{ $stats['maintenance_requests'] ?? 0 }}</div>
                            <div class="weight-499 font-14">Solicitudes Pendientes</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Cronogramas -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Mis Próximas Actividades</h5>
                    <a href="{{ route('schedules.calendar') }}" class="btn btn-sm btn-outline-primary">
                        Ver Todas
                    </a>
                </div>
                <div class="card-body">
                    @if($upcomingActivities->count() > 0)
                        @foreach($upcomingActivities as $activity)
                        <div class="alert alert-{{ $activity->priority_class }} mb-2 p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="alert-heading mb-1">{{ $activity->title }}</h6>
                                    <small class="mb-1 d-block">
                                        <i class="fas fa-clock"></i> 
                                        {{ $activity->start_date->format('M d, H:i') }}
                                    </small>
                                    <span class="badge bg-{{ $activity->type_badge }}">
                                        {{ $activity->activity_type_label }}
                                    </span>
                                    @if($activity->asset)
                                    <span class="badge bg-info">
                                        {{ $activity->asset->nombre_equipo }}
                                    </span>
                                    @endif
                                </div>
                                <a href="{{ route('schedules.show', $activity) }}" 
                                   class="btn btn-sm btn-outline-dark">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="text-muted mb-0">No tienes actividades próximas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Actividades Urgentes</h5>
                    <a href="{{ route('schedules.index', ['priority' => 'urgent']) }}" 
                       class="btn btn-sm btn-outline-danger">
                        Ver Urgentes
                    </a>
                </div>
                <div class="card-body">
                    @if($urgentActivities->count() > 0)
                        @foreach($urgentActivities as $activity)
                        <div class="alert alert-danger mb-2 p-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="alert-heading mb-1">
                                        <i class="fas fa-exclamation-triangle"></i> 
                                        {{ $activity->title }}
                                    </h6>
                                    <small class="mb-1 d-block">
                                        <i class="fas fa-user"></i> 
                                        {{ $activity->assignedUser->name }}
                                    </small>
                                    <small class="mb-1 d-block">
                                        <i class="fas fa-clock"></i> 
                                        {{ $activity->start_date->format('M d, H:i') }}
                                    </small>
                                    <span class="badge bg-{{ $activity->type_badge }}">
                                        {{ $activity->activity_type_label }}
                                    </span>
                                </div>
                                <a href="{{ route('schedules.show', $activity) }}" 
                                   class="btn btn-sm btn-outline-light">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-3">
                            <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                            <p class="text-muted mb-0">No hay actividades urgentes</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de estadísticas con iconos -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $stats['asset_count'] ?? 0 }}</h3>
                            <p class="mb-0">Total Actividades</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $stats['pending_activities'] ?? 0 }}</h3>
                            <p class="mb-0">Pendientes</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $stats['completed_activities'] ?? 0 }}</h3>
                            <p class="mb-0">Completadas</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h3 class="mb-0">{{ $stats['urgent_activities'] ?? 0 }}</h3>
                            <p class="mb-0">Urgentes</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection