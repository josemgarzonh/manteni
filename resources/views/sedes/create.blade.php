@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Añadir Nueva Sede</h2>
    <div class="pd-20">
        <form action="{{ route('sedes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>IPS a la que Pertenece</label>
                <select class="form-control" name="ips_id" required>
                    <option value="" disabled selected>Seleccione una IPS...</option>
                    @foreach($ips as $ip)
                        <option value="{{ $ip->id }}">{{ $ip->nombre_prestador }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Nombre de la Sede</label>
                <input class="form-control" type="text" name="nombre_sede" required>
            </div>
            <div class="form-group">
                <label>Dirección</label>
                <input class="form-control" type="text" name="direccion">
            </div>
             <div class="form-group">
                <label>Teléfono</label>
                <input class="form-control" type="text" name="telefono">
            </div>
            <div class="text-right">
                <a href="{{ route('sedes.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Sede</button>
            </div>
        </form>
    </div>
</div>
@endsection