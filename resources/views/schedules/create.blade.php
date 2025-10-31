
// resources/views/schedules/create.blade.php

@extends('layouts.app')

@section('title', 'Crear Actividad Programada')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Crear Nueva Actividad Programada</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('schedules.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Título *</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           name="title" value="{{ old('title') }}" required>
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
                                        <option value="hospital_round" {{ old('activity_type') == 'hospital_round' ? 'selected' : '' }}>Ronda Hospitalaria</option>
                                        <option value="defibrillator_test" {{ old('activity_type') == 'defibrillator_test' ? 'selected' : '' }}>Test Desfibrilador</option>
                                        <option value="preventive_maintenance" {{ old('activity_type') == 'preventive_maintenance' ? 'selected' : '' }}>Mantenimiento Preventivo</option>
                                        <option value="calibration" {{ old('activity_type') == 'calibration' ? 'selected' : '' }}>Calibración</option>
                                        <option value="training" {{ old('activity_type') == 'training' ? 'selected' : '' }}>Capacitación</option>
                                        <option value="intervention" {{ old('activity_type') == 'intervention' ? 'selected' : '' }}>Intervención</option>
                                        <option value="failure_attention" {{ old('activity_type') == 'failure_attention' ? 'selected' : '' }}>Atención de Falla</option>
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
                                      name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha y Hora de Inicio *</label>
                                    <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                           name="start_date" value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Fecha y Hora de Fin *</label>
                                    <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                           name="end_date" value="{{ old('end_date') }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Prioridad *</label>
                                    <select class="form-select @error('priority') is-invalid @enderror" name="priority" required>
                                        <option value="">Seleccionar prioridad</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Baja</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Media</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Alta</option>
                                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgente</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Asignado a *</label>
                                    <select class="form-select @error('assigned_to') is-invalid @enderror" 
                                            name="assigned_to" required>
                                        <option value="">Seleccionar usuario</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('assigned_to') == $user->id ? 'selected' : '' }}>
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
                                            <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
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
                                            <option value="{{ $sede->id }}" {{ old('sede_id') == $sede->id ? 'selected' : '' }}>
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
                                            <option value="{{ $servicio->id }}" {{ old('servicio_id') == $servicio->id ? 'selected' : '' }}>
                                                {{ $servicio->nombre_servicio }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Recordatorios (Opcional)</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="reminders[]" value="15" 
                                       id="reminder15" {{ in_array(15, old('reminders', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="reminder15">
                                    15 minutos antes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="reminders[]" value="30" 
                                       id="reminder30" {{ in_array(30, old('reminders', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="reminder30">
                                    30 minutos antes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="reminders[]" value="60" 
                                       id="reminder60" {{ in_array(60, old('reminders', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="reminder60">
                                    1 hora antes
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="reminders[]" value="1440" 
                                       id="reminder1440" {{ in_array(1440, old('reminders', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="reminder1440">
                                    1 día antes
                                </label>
                            </div>
                        </div>

                        <div class="text-end">
                            <a href="{{ route('schedules.calendar') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Crear Actividad</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection