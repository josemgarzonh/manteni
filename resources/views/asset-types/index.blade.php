@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4 float-left">Gestionar Tipos de Activo</h2>
        <a href="{{ route('asset-types.create') }}" class="btn btn-primary float-right">Añadir Nuevo Tipo</a>
    </div>
    <div class="pb-20">
        <table class="table table-striped">
            <thead><tr><th>ID</th><th>Nombre del Tipo</th><th>Acciones</th></tr></thead>
            <tbody>
                @foreach($assetTypes as $type)
                <tr>
                    <td>{{ $type->id }}</td>
                    <td>{{ $type->nombre }}</td>
                    <td>
                        <a href="{{ route('asset-types.edit', $type->id) }}" class="btn btn-sm btn-primary">Editar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection