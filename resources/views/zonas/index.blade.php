@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4 float-left">Gestionar Zonas</h2>
        <a href="{{ route('zonas.create') }}" class="btn btn-primary float-right">Añadir Nueva Zona</a>
    </div>
    <div class="pb-20">
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>Nombre de la Zona</th><th>Sede</th><th>Servicio</th><th>Acciones</th></tr></thead>
            <tbody>
                @foreach($zonas as $zona)
                <tr>
                    <td>{{ $zona->id }}</td>
                    <td>{{ $zona->nombre_zona }}</td>
                    <td>{{ $zona->sede->nombre_sede ?? 'N/A' }}</td>
                    <td>{{ $zona->servicio->nombre_servicio ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('zonas.edit', $zona->id) }}" class="btn btn-sm btn-primary">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection