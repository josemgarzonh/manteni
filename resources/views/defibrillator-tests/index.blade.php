@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4 float-left">Historial de Tests de Desfibriladores</h2>
        <a href="{{ route('defibrillator-tests.create') }}" class="btn btn-primary float-right">Registrar Nuevo Test</a>
    </div>
    <div class="pb-20">
        @if (session('success'))
            <div class="alert alert-success mx-4">{{ session('success') }}</div>
        @endif
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Equipo</th>
                    <th>Servicio</th>
                    <th>Realizado por</th>
                    <th>Responsable Servicio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tests as $test)
                <tr>
                    <td>{{ $test->created_at->format('Y-m-d') }}</td>
                    <td>{{ $test->asset->nombre_equipo ?? 'N/A' }}</td>
                    <td>{{ $test->servicio->nombre_servicio ?? 'N/A' }}</td>
                    <td>{{ $test->user->name ?? 'N/A' }}</td>
                    <td>{{ $test->responsable_servicio_nombre }}</td>
                    <td>
                        {{-- Aquí irían botones para Ver Detalle, Editar, etc. en el futuro --}}
                        <a href="#" class="btn btn-sm btn-info">Ver</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No hay tests registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection