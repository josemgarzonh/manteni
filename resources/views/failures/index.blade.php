@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4">Listado General de Fallas Reportadas</h2>
    </div>
    <div class="pb-20">
        @if (session('success'))
            <div class="alert alert-success mx-4">{{ session('success') }}</div>
        @endif
        <table class="data-table table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha Reporte</th>
                    <th>Reportado por</th>
                    <th>Equipo</th>
                    <th>Estado Falla</th>
                    <th>Tiempo Atención</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($failures as $failure)
                <tr>
                    <td>{{ $failure->id }}</td>
                    <td>{{ $failure->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $failure->user->name ?? $failure->solicitante_nombre }}</td>
                    <td>{{ $failure->asset->nombre_equipo ?? 'No especificado' }}</td>
                    <td>
                        @php
                            $badgeClass = '';
                            switch ($failure->estado_falla) {
                                case 'despejada': $badgeClass = 'badge-success'; break;
                                case 'postergada': $badgeClass = 'badge-warning'; break;
                                case 'en espera': $badgeClass = 'badge-info'; break;
                                case 'activa': default: $badgeClass = 'badge-danger'; break;
                            }
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ ucfirst($failure->estado_falla ?? 'Activa') }}</span>
                    </td>
                    <td>
                        @if ($failure->attended_at)
                            {{ $failure->created_at->diffForHumans($failure->attended_at, true) }}
                        @else
                            <span class="badge badge-secondary">Sin atender</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('failures.attend', $failure->id) }}" class="btn btn-sm btn-primary">Ver / Atender</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No hay fallas reportadas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection