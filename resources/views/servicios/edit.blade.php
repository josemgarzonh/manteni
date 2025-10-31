@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Editar Servicio</h2>
    <div class="pd-20">
        <form action="{{ route('servicios.update', $servicio->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Sede a la que Pertenece</label>
                <select class="form-control" name="sede_id" required>
                    @foreach($sedes as $sede)
                        <option value="{{ $sede->id }}" {{ $servicio->sede_id == $sede->id ? 'selected' : '' }}>{{ $sede->nombre_sede }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group"><label>Nombre del Servicio</label><input class="form-control" type="text" name="nombre_servicio" value="{{ $servicio->nombre_servicio }}" required></div>
            <div class="form-group"><label>Código del Servicio (Opcional)</label><input class="form-control" type="text" name="codigo_servicio" value="{{ $servicio->codigo_servicio }}"></div>
            <div class="form-group"><label>Grupo del Servicio (Opcional)</label><input class="form-control" type="text" name="grupo_servicio" value="{{ $servicio->grupo_servicio }}"></div>
            <div class="text-right">
                <a href="{{ route('servicios.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Servicio</button>
            </div>
        </form>
    </div>
</div>
@endsection