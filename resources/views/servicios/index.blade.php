@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4 float-left">Gestionar Servicios</h2>
        <a href="{{ route('servicios.create') }}" class="btn btn-primary float-right">Añadir Nuevo Servicio</a>
    </div>
    <div class="pb-20">
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>Nombre del Servicio</th><th>Sede a la que Pertenece</th><th>Acciones</th></tr></thead>
            <tbody>
                @foreach($servicios as $servicio)
                <tr>
                    <td>{{ $servicio->id }}</td>
                    <td>{{ $servicio->nombre_servicio }}</td>
                    <td>{{ $servicio->sede->nombre_sede ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('servicios.edit', $servicio->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        {{-- Formulario de borrado --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection