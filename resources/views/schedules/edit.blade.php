{{-- resources/views/schedules/edit.blade.php --}}

@extends('layouts.app')

@section('title', 'Editar Actividad Programada')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Editar Actividad Programada</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('schedules.update', $schedule) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Título *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           name="title" value="{{ old('title', $schedule->title) }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Actividad *</label>
                                    <select class="form-select @error('activity_type') is-invalid @enderror" 
                                            name="activity_type" required>
                                        <option value="">Seleccionar tipo</option>
                                        <option value="hospital_round" {{ old('activity_type', $schedule->activity_type) == 'hospital_round' ? 'selected' : '' }}>Ronda Hospitalaria</option>
                                        <option value="defibrillator_test" {{ old('activity_type', $schedule->activity_type) == 'defibrillator_test' ? 'selected' : '' }}>Test Desfibrilador</option>
                                        <option value="preventive_maintenance" {{ old('activity_type', $schedule->activity_type) == 'preventive_maintenance' ? 'selected' : '' }}>Mantenimiento Preventivo</option>
                                        <option value="calibration" {{ old('activity_type', $schedule->activity_type) == 'calibration' ? 'selected' : '' }}>Calibración</option>
                                        <option value="training" {{ old('activity_type', $schedule->activity_type) == 'training' ? 'selected' : '' }}>Capacitación</option>
                                        <option value="intervention" {{ old('activity_type', $schedule->activity_type) == 'intervention' ? 'selected' : '' }}>Intervención</option>
                                        <option value="failure_attention" {{ old('activity_type', $schedule->activity_type) == 'failure_attention' ? 'selected' : '' }}>Atención de Falla</option>
                                    </select>
                                    @error('activity_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      name="description" rows="3">{{ old('description', $schedule->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha y Hora de Inicio *</label>
                                    <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                           name="start_date" value="{{ old('start_date', $schedule->start_date->format('Y-m-d\TH:i')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha y Hora de Fin *</label>
                                    <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                           name="end_date" value="{{ old('end_date', $schedule->end_date->format('Y-m-d\TH:i')) }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Estado *</label>
                                    <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                        <option value="pending" {{ old('status', $schedule->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="in_progress" {{ old('status', $schedule->status) == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                                        <option value="completed" {{ old('status', $schedule->status) == 'completed' ? 'selected' : '' }}>Completado</option>
                                        <option value="cancelled" {{ old('status', $schedule->status) == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Prioridad *</label>
                                    <select class="form-select @error('priority') is-invalid @enderror" name="priority" required>
                                        <option value="low" {{ old('priority', $schedule->priority) == 'low' ? 'selected' : '' }}>Baja</option>
                                        <option value="medium" {{ old('priority', $schedule->priority) == 'medium' ? 'selected' : '' }}>Media</option>
                                        <option value="high" {{ old('priority', $schedule->priority) == 'high' ? 'selected' : '' }}>Alta</option>
                                        <option value="urgent" {{ old('priority', $schedule->priority) == 'urgent' ? 'selected' : '' }}>Urgente</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Asignado a *</label>
                                    <select class="form-select @error('assigned_to') is-invalid @enderror" 
                                            name="assigned_to" required>
                                        <option value="">Seleccionar usuario</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('assigned_to', $schedule->assigned_to) == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('assigned_to')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Equipo (Opcional)</label>
                                    <select class="form-select" name="asset_id">
                                        <option value="">Sin equipo específico</option>
                                        @foreach($assets as $asset)
                                            <option value="{{ $asset->id }}" {{ old('asset_id', $schedule->asset_id) == $asset->id ? 'selected' : '' }}>
                                                {{ $asset->nombre_equipo }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Sede (Opcional)</label>
                                    <select class="form-select" name="sede_id">
                                        <option value="">Todas las sedes</option>
                                        @foreach($sedes as $sede)
                                            <option value="{{ $sede->id }}" {{ old('sede_id', $schedule->sede_id) == $sede->id ? 'selected' : '' }}>
                                                {{ $sede->nombre_sede }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label">Servicio (Opcional)</label>
                                    <select class="form-select" name="servicio_id">
                                        <option value="">Todos los servicios</option>
                                        @foreach($servicios as $servicio)
                                            <option value="{{ $servicio->id }}" {{ old('servicio_id', $schedule->servicio_id) == $servicio->id ? 'selected' : '' }}>
                                                {{ $servicio->nombre_servicio }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('schedules.show', $schedule) }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Actividad</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection