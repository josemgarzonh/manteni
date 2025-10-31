@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4">Bandeja de Repuestos Solicitados</h2>
    </div>
    <div class="pb-20">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Solicitante</th>
                    <th>Equipo</th>
                    <th>Nombre del Repuesto</th>
                    <th>Cantidad</th>
                    <th>Foto</th>
                    <th>Reporte No.</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                <tr>
                    <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $request->user->name }}</td>
                    <td>{{ $request->asset->nombre_equipo }}</td>
                    <td>{{ $request->part_name }}</td>
                    <td>{{ $request->quantity }}</td>
                    <td>
                        @if($request->photo_url)
                            <a href="{{ asset('storage/' . $request->photo_url) }}" target="_blank">
                                <img src="{{ asset('storage/' . $request->photo_url) }}" alt="Foto del repuesto" width="50">
                            </a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($request->maintenance_report_id)
                            <a href="{{ route('maintenance-reports.show', $request->maintenance_report_id) }}">
                                {{ $request->maintenance_report_id }}
                            </a>
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        {{-- Aquí se podría añadir lógica para cambiar el estado --}}
                        <span class="badge badge-info">{{ ucfirst($request->status) }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No hay solicitudes de repuestos pendientes.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection