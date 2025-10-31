@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Añadir Nuevo Tipo de Activo</h2>
    <div class="pd-20">
        <form action="{{ route('asset-types.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Nombre del Tipo de Activo</label>
                <input class="form-control" type="text" name="nombre" required>
            </div>
            <div class="text-right">
                <a href="{{ route('asset-types.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Tipo</button>
            </div>
        </form>
    </div>
</div>
@endsection