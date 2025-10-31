@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <div class="pd-20 clearfix">
        <h2 class="h4 float-left">Bitácora de Mantenimiento</h2>
        
        <a href="{{ route('assets.bitacora.pdf', $asset->id) }}" class="btn btn-primary float-right" target="_blank">Descargar PDF</a>
        
    </div>

    {{-- INFORMACIÓN DEL PRESTADOR Y EQUIPO --}}
    <div class="pd-20 border-top">
        <h5 class="h5">Información del Prestador</h5>
        <p><strong>Nombre:</strong> {{ $asset->sede->ips->nombre_prestador ?? 'N/A' }} / <strong>Sede:</strong> {{ $asset->sede->nombre_sede ?? 'N/A' }}</p>
        {{-- ... otros campos de la IPS ... --}}
        <h5 class="h5 mt-3">Información del Equipo</h5>
        <p><strong>Equipo:</strong> {{ $asset->nombre_equipo }} / <strong>Marca:</strong> {{ $asset->marca }} / <strong>Modelo:</strong> {{ $asset->modelo }}</p>
        {{-- ... otros campos del equipo ... --}}
    </div>

    {{-- TABLA DE LA BITÁCORA --}}
    <div class="pb-20">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Descripción de la Actividad</th>
                    <th>Responsable</th>
                    <th>Fecha Próxima Intervención</th>
                    <th>No. de Reporte</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($asset->maintenanceReports as $report)
                <tr>
                    <td>{{ $report->created_at->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($report->tipo_mantenimiento) }}</td>
                    <td>{{ $report->is_manual_entry ? $report->manual_responsable : $report->tecnico->name }}</td>
                    <td>{{ $report->next_intervention_date ? \Carbon\Carbon::parse($report->next_intervention_date)->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ !$report->is_manual_entry ? $report->id : 'Manual' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">No hay registros en la bitácora para este equipo.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- FORMULARIO DE ENTRADA MANUAL --}}
    <div class="pd-20 border-top">
        <h5 class="h5">Añadir Entrada Manual a la Bitácora</h5>
        <form action="{{ route('assets.bitacora.store', $asset->id) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-3"><input type="date" name="created_at" class="form-control" required></div>
                <div class="col-md-3"><input type="text" name="tipo_mantenimiento" class="form-control" placeholder="Descripción Actividad" required></div>
                <div class="col-md-3"><input type="text" name="manual_responsable" class="form-control" placeholder="Responsable" required></div>
                <div class="col-md-3"><input type="date" name="next_intervention_date" class="form-control"></div>
            </div>
            <div class="text-right mt-3">
                <button type="submit" class="btn btn-success">Añadir Registro Manual</button>
            </div>
        </form>
    </div>
</div>
@endsection