{{-- resources/views/schedules/show.blade.php --}}

@extends('layouts.app')


@section('title', 'Detalle de Actividad')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Detalle de Actividad</h5>
                    <div class="btn-group">
                        <a href="{{ route('schedules.edit', $schedule) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <a href="{{ route('schedules.calendar') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-calendar"></i> Calendario
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Información General</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Título:</th>
                                    <td>{{ $schedule->title }}</td>
                                </tr>
                                <tr>
                                    <th>Tipo:</th>
                                    <td>
                                        <span class="badge bg-{{ $schedule->type_badge }}">
                                            {{ $schedule->activity_type_label }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Descripción:</th>
                                    <td>{{ $schedule->description ?: 'Sin descripción' }}</td>
                                </tr>
                                <tr>
                                    <th>Prioridad:</th>
                                    <td>
                                        <span class="badge bg-{{ $schedule->priority_class }}">
                                            {{ ucfirst($schedule->priority) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Estado:</th>
                                    <td>
                                        <span class="badge 
                                            @if($schedule->status == 'completed') bg-success
                                            @elseif($schedule->status == 'in_progress') bg-primary
                                            @elseif($schedule->status == 'cancelled') bg-secondary
                                            @else bg-warning @endif">
                                            {{ ucfirst($schedule->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6>Fechas y Asignación</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Inicio:</th>
                                    <td>{{ $schedule->start_date->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Fin:</th>
                                    <td>{{ $schedule->end_date->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Asignado a:</th>
                                    <td>{{ $schedule->assignedUser->name }}</td>
                                </tr>
                                <tr>
                                    <th>Creado por:</th>
                                    <td>{{ $schedule->creator->name }}</td>
                                </tr>
                                <tr>
                                    <th>Creación:</th>
                                    <td>{{ $schedule->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($schedule->asset || $schedule->sede || $schedule->servicio)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6>Ubicación y Equipo</h6>
                            <table class="table table-borderless">
                                @if($schedule->asset)
                                <tr>
                                    <th width="30%">Equipo:</th>
                                    <td>{{ $schedule->asset->nombre_equipo }}</td>
                                </tr>
                                @endif
                                @if($schedule->sede)
                                <tr>
                                    <th>Sede:</th>
                                    <td>{{ $schedule->sede->nombre_sede }}</td>
                                </tr>
                                @endif
                                @if($schedule->servicio)
                                <tr>
                                    <th>Servicio:</th>
                                    <td>{{ $schedule->servicio->nombre_servicio }}</td>
                                </tr>
                                @endif
                                @if($schedule->zone)
                                <tr>
                                    <th>Zona:</th>
                                    <td>{{ $schedule->zone->nombre_zona }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    @endif

                    @if($schedule->reminders->count() > 0)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6>Recordatorios Programados</h6>
                            <div class="list-group">
                                @foreach($schedule->reminders as $reminder)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>
                                        {{ $reminder->remind_minutes_before }} minutos antes
                                    </span>
                                    <span class="badge bg-{{ $reminder->sent ? 'success' : 'secondary' }}">
                                        {{ $reminder->sent ? 'Enviado' : 'Pendiente' }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Formulario para cambiar estado -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6>Cambiar Estado</h6>
                            <form action="{{ route('schedules.status.update', $schedule) }}" method="POST" class="d-inline">
                                @csrf
                                <div class="btn-group">
                                    <button type="submit" name="status" value="pending" 
                                            class="btn btn-outline-warning btn-sm {{ $schedule->status == 'pending' ? 'active' : '' }}">
                                        Pendiente
                                    </button>
                                    <button type="submit" name="status" value="in_progress" 
                                            class="btn btn-outline-primary btn-sm {{ $schedule->status == 'in_progress' ? 'active' : '' }}">
                                        En Progreso
                                    </button>
                                    <button type="submit" name="status" value="completed" 
                                            class="btn btn-outline-success btn-sm {{ $schedule->status == 'completed' ? 'active' : '' }}">
                                        Completado
                                    </button>
                                    <button type="submit" name="status" value="cancelled" 
                                            class="btn btn-outline-secondary btn-sm {{ $schedule->status == 'cancelled' ? 'active' : '' }}">
                                        Cancelado
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection