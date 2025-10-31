@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <div class="pd-20 d-flex justify-content-between align-items-center">
        <h2 class="h4">Historial de Rondas Hospitalarias</h2>
        <a href="{{ route('hospital-rounds.create') }}" class="btn btn-primary">Registrar Nueva Ronda</a>
    </div>
    <div class="pb-20">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Realizada por</th>
                    <th>Sede</th>
                    <th>Servicio</th>
                    <th>¿Fallas?</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rounds as $round)
                <tr>
                    <td>{{ $round->id }}</td>
                    <td>{{ $round->created_at->format('Y-m-d H:i') }}</td>
                    <td>{{ $round->user->name }}</td>
                    <td>{{ $round->sede->nombre_sede ?? 'N/A' }}</td>
                    <td>{{ $round->servicio->nombre_servicio ?? 'N/A' }}</td>
                    <td>
                        @if($round->found_failures)
                            <span class="badge badge-danger">Sí</span>
                        @else
                            <span class="badge badge-success">No</span>
                        @endif
                    </td>
                    <td>
                        @if($round->found_failures)
                            <a href="{{ route('hospital-rounds.show', $round->id) }}" class="btn btn-sm btn-info">Ver Detalles</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">No hay rondas registradas.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection