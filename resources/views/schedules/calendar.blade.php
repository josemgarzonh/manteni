<?php
// resources/views/schedules/calendar.blade.php

@extends('layouts.app')

@section('title', 'Calendario de Actividades')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <!-- Filtros -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Filtros</h5>
                </div>
                <div class="card-body">
                    <form id="filterForm">
                        <div class="mb-3">
                            <label class="form-label">Tipo de Actividad</label>
                            <select class="form-select" name="type" id="activityTypeFilter">
                                <option value="">Todos los tipos</option>
                                <option value="hospital_round">Rondas Hospitalarias</option>
                                <option value="defibrillator_test">Tests Desfibriladores</option>
                                <option value="preventive_maintenance">Mantenimientos Preventivos</option>
                                <option value="calibration">Calibraciones</option>
                                <option value="training">Capacitaciones</option>
                                <option value="intervention">Intervenciones</option>
                                <option value="failure_attention">Atención de Fallas</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Sede</label>
                            <select class="form-select" name="sede_id" id="sedeFilter">
                                <option value="">Todas las sedes</option>
                                @foreach($sedes as $sede)
                                    <option value="{{ $sede->id }}">{{ $sede->nombre_sede }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Servicio</label>
                            <select class="form-select" name="servicio_id" id="servicioFilter">
                                <option value="">Todos los servicios</option>
                                @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre_servicio }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prioridad</label>
                            <select class="form-select" name="priority" id="priorityFilter">
                                <option value="">Todas las prioridades</option>
                                <option value="low">Baja</option>
                                <option value="medium">Media</option>
                                <option value="high">Alta</option>
                                <option value="urgent">Urgente</option>
                            </select>
                        </div>
                        
                        <button type="button" class="btn btn-primary w-100" id="applyFilters">
                            Aplicar Filtros
                        </button>
                        <button type="button" class="btn btn-outline-secondary w-100 mt-2" id="clearFilters">
                            Limpiar Filtros
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Acciones rápidas -->
            <div class="card mt-3">
                <div class="card-body">
                    <a href="{{ route('schedules.create') }}" class="btn btn-success w-100 mb-2">
                        <i class="fas fa-plus"></i> Nueva Actividad
                    </a>
                    <a href="{{ route('schedules.index') }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-list"></i> Ver Lista
                    </a>
                </div>
            </div>

            <!-- Leyenda -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="card-title">Leyenda</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="legend-color" style="background-color: #3B82F6; width: 15px; height: 15px; margin-right: 8px;"></div>
                        <small>Rondas Hospitalarias</small>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="legend-color" style="background-color: #10B981; width: 15px; height: 15px; margin-right: 8px;"></div>
                        <small>Tests Desfibriladores</small>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="legend-color" style="background-color: #F59E0B; width: 15px; height: 15px; margin-right: 8px;"></div>
                        <small>Mantenimientos</small>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="legend-color" style="background-color: #8B5CF6; width: 15px; height: 15px; margin-right: 8px;"></div>
                        <small>Calibraciones</small>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="legend-color" style="background-color: #EC4899; width: 15px; height: 15px; margin-right: 8px;"></div>
                        <small>Capacitaciones</small>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="legend-color" style="background-color: #EF4444; width: 15px; height: 15px; margin-right: 8px;"></div>
                        <small>Intervenciones/Fallas</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Calendario de Actividades</h5>
                    <div class="btn-group">
                        <button class="btn btn-outline-primary btn-sm" id="prevBtn">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="btn btn-outline-primary btn-sm" id="nextBtn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <button class="btn btn-outline-primary btn-sm" id="todayBtn">
                            Hoy
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<style>
    .legend-color {
        border-radius: 3px;
        border: 1px solid #ddd;
    }
    .fc-event {
        cursor: pointer;
    }
    .fc-toolbar {
        flex-wrap: wrap;
    }
</style>
@endpush

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'title',
            center: '',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek prev,next'
        },
        events: @json($activities),
        eventClick: function(info) {
            window.location.href = `/schedules/${info.event.id}/show`;
        },
        eventDidMount: function(info) {
            // Tooltip con información adicional
            info.el.setAttribute('title', 
                `${info.event.extendedProps.type_label}\n` +
                `Asignado a: ${info.event.extendedProps.assigned_to}\n` +
                `Prioridad: ${info.event.extendedProps.priority}\n` +
                `Estado: ${info.event.extendedProps.status}`
            );
        },
        locale: 'es',
        buttonText: {
            today: 'Hoy',
            month: 'Mes',
            week: 'Semana',
            day: 'Día',
            list: 'Lista'
        }
    });

    calendar.render();

    // Controles de navegación
    document.getElementById('prevBtn').addEventListener('click', function() {
        calendar.prev();
    });

    document.getElementById('nextBtn').addEventListener('click', function() {
        calendar.next();
    });

    document.getElementById('todayBtn').addEventListener('click', function() {
        calendar.today();
    });

    // Filtros
    document.getElementById('applyFilters').addEventListener('click', function() {
        const formData = new FormData(document.getElementById('filterForm'));
        const params = new URLSearchParams(formData);
        window.location.href = '{{ route("schedules.calendar") }}?' + params.toString();
    });

    document.getElementById('clearFilters').addEventListener('click', function() {
        window.location.href = '{{ route("schedules.calendar") }}';
    });

    // Preservar valores de filtros en la URL
    const urlParams = new URLSearchParams(window.location.search);
    document.getElementById('activityTypeFilter').value = urlParams.get('type') || '';
    document.getElementById('sedeFilter').value = urlParams.get('sede_id') || '';
    document.getElementById('servicioFilter').value = urlParams.get('servicio_id') || '';
    document.getElementById('priorityFilter').value = urlParams.get('priority') || '';
});
</script>
@endpush