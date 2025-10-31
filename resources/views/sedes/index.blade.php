@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4 float-left">Gestionar Sedes</h2>
        <a href="{{ route('sedes.create') }}" class="btn btn-primary float-right">Añadir Nueva Sede</a>
    </div>
    <div class="pb-20">
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>Nombre de la Sede</th><th>IPS a la que Pertenece</th><th>Acciones</th></tr></thead>
            <tbody>
                @foreach($sedes as $sede)
                <tr>
                    <td>{{ $sede->id }}</td>
                    <td>{{ $sede->nombre_sede }}</td>
                    <td>{{ $sede->ips->nombre_prestador ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('sedes.edit', $sede->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        {{-- Formulario de borrado --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection