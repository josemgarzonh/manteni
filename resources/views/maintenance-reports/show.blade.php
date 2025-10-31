@extends('layouts.app')

@section('content')
<div class="card-box mb-30 pd-20">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Reporte de Mantenimiento No. {{ $report->id }}</h4>
            <p class="mb-30">Fecha de Emisión: {{ $report->created_at ? $report->created_at->format('d/m/Y H:i A') : 'Fecha no disponible' }}</p>
        </div>
        <div class="pull-right">
            <a href="{{ route('maintenance-reports.pdf', $report->id) }}" class="btn btn-primary" target="_blank">Imprimir / Descargar PDF</a>
        </div>
    </div>

    <h5 class="h5 mb-20 mt-3">Información del Equipo</h5>
    <table class="table table-bordered">
        <tr>
            <th>Equipo</th><td>{{ optional($report->asset)->nombre_equipo ?? 'N/A' }}</td>
            <th>Marca</th><td>{{ optional($report->asset)->marca ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Modelo</th><td>{{ optional($report->asset)->modelo ?? 'N/A' }}</td>
            <th>Serie</th><td>{{ optional($report->asset)->serie ?? 'N/A' }}</td>
        </tr>
         <tr>
            <th>Activo Fijo</th><td>{{ optional($report->asset)->activo_fijo ?? 'N/A' }}</td>
            <th>Ubicación</th><td>{{ optional(optional($report->asset)->sede)->nombre_sede ?? 'Sede no disponible' }} - {{ optional(optional($report->asset)->zona)->nombre_zona ?? 'N/A' }}</td>
        </tr>
    </table>

    <h5 class="h5 mb-20 mt-3">Detalles del Servicio</h5>
    <table class="table table-bordered">
         <tr>
            <th>Tipo de Mantenimiento</th><td>{{ ucfirst($report->tipo_mantenimiento) }}</td>
            <th>Tiempo de Ejecución</th><td>{{ $report->tiempo_ejecucion_horas ?? 'N/A' }} horas</td>
        </tr>
        <tr>
            <th>Observaciones</th><td colspan="3">{{ $report->observaciones ?? 'Sin observaciones.' }}</td>
        </tr>
    </table>

    @if($report->sparePartRequests && $report->sparePartRequests->isNotEmpty())
    <h5 class="h5 mb-20 mt-3">Repuestos Solicitados</h5>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre del Repuesto</th>
                <th>Cantidad</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report->sparePartRequests as $sparePart)
                <tr>
                    <td>{{ $sparePart->part_name }}</td>
                    <td>{{ $sparePart->quantity }}</td>
                    <td>
                        @if($sparePart->photo_url)
                            <a href="{{ asset('storage/' . $sparePart->photo_url) }}" target="_blank">Ver Foto</a>
                        @else
                            Sin foto
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <h5 class="h5 mb-20 mt-3">Checklist de Verificación</h5>
    <div class="row">
         @foreach ($report->checklistItems->chunk(ceil($report->checklistItems->count() / 3)) as $chunk)
            <div class="col-md-4">
                <ul class="list-group">
                    @foreach ($chunk as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $item->item_nombre }}
                            @php
                                $badgeClass = 'badge-secondary'; // Default
                                if ($item->estado == 'si') $badgeClass = 'badge-success';
                                if ($item->estado == 'no') $badgeClass = 'badge-danger';
                            @endphp
                            <span class="badge {{ $badgeClass }} badge-pill">{{ strtoupper($item->estado) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <h5 class="h5 mb-20 mt-3">Responsables</h5>
     <table class="table table-bordered">
        <tr>
            <th>Técnico Responsable</th><td>{{ optional($report->tecnico)->name ?? 'N/A' }}</td>
            <th>Recibido por</th><td>{{ $report->recibe_nombre ?? 'N/A' }}</td>
        </tr>
         <tr>
            <th>Cargo Técnico</th><td>{{ optional($report->tecnico)->cargo ?? 'N/A' }}</td>
            <th>Cargo Recibe</th><td>{{ $report->recibe_cargo ?? 'N/A' }}</td>
        </tr>
    </table>

    <div class="text-right mt-4">
         <a href="{{ route('maintenance-reports.index') }}" class="btn btn-secondary">Volver a la lista</a>
    </div>
</div>
@endsection