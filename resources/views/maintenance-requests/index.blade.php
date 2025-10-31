@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4">Bandeja de Solicitudes de Mantenimiento</h2>
    </div>
    <div class="pb-20">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Solicitante</th>
                    <th>Ubicación</th>
                    <th>Descripción Breve</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $request)
                <tr>
                    <td>{{ $request->id }}</td>
                    <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $request->user->name ?? $request->solicitante_nombre }}</td>
                    <td>{{ $request->ubicacion_texto }}</td>
                    <td>{{ Str::limit($request->descripcion, 50) }}</td>
                    <td>
                        {{-- ====================================================== --}}
                        {{-- INICIO DE LA MODIFICACIÓN: LÓGICA PARA COLORES DE ESTADO --}}
                        {{-- ====================================================== --}}
                        @php
                            $badgeClass = '';
                            switch ($request->estado) {
                                case 'Pendiente':
                                    $badgeClass = 'badge-danger'; // Rojo
                                    break;
                                case 'Finalizada':
                                    $badgeClass = 'badge-success'; // Verde
                                    break;
                                case 'En Proceso':
                                    $badgeClass = 'badge-warning'; // Naranja
                                    break;
                                case 'Asignada':
                                    $badgeClass = 'badge-info'; // Azul
                                    break;
                                case 'Rechazada':
                                    $badgeClass = 'badge-secondary'; // Gris
                                    break;
                                default:
                                    $badgeClass = 'badge-light';
                            }
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $request->estado }}</span>
                        {{-- ==================================================== --}}
                        {{-- FIN DE LA MODIFICACIÓN: LÓGICA PARA COLORES DE ESTADO --}}
                        {{-- ==================================================== --}}
                    </td>
                    <td>
                        {{-- ====================================================== --}}
                        {{-- INICIO DE LA MODIFICACIÓN: BOTÓN DUPLICADO ELIMINADO --}}
                        {{-- ====================================================== --}}
                        <a href="{{ route('maintenance-requests.show', $request->id) }}" class="btn btn-info btn-sm">Ver / Asignar</a>
                        {{-- ==================================================== --}}
                        {{-- FIN DE LA MODIFICACIÓN: BOTÓN DUPLICADO ELIMINADO --}}
                        {{-- ==================================================== --}}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No hay solicitudes pendientes.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection