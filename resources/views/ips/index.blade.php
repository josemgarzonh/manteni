@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4 float-left">Gestionar IPS</h2>
        <a href="{{ route('ips.create') }}" class="btn btn-primary float-right">Añadir Nueva IPS</a>
    </div>
    <div class="pb-20">
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>Nombre del Prestador</th><th>NIT</th><th>Acciones</th></tr></thead>
            <tbody>
                @foreach($ips as $ip)
                <tr>
                    <td>{{ $ip->id }}</td>
                    <td>{{ $ip->nombre_prestador }}</td>
                    <td>{{ $ip->nit }}</td>
                    <td>
                        <a href="{{ route('ips.edit', $ip->id) }}" class="btn btn-sm btn-primary">Editar</a>
                        {{-- Formulario de borrado --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection