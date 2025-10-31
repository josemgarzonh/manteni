@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Editar Sede: {{ $sede->nombre_sede }}</h2>
    <div class="pd-20">
        <form action="{{ route('sedes.update', $sede->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>IPS a la que Pertenece</label>
                <select class="form-control" name="ips_id" required>
                    @foreach($ips as $ip)
                        <option value="{{ $ip->id }}" {{ $sede->ips_id == $ip->id ? 'selected' : '' }}>
                            {{ $ip->nombre_prestador }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Nombre de la Sede</label>
                <input class="form-control" type="text" name="nombre_sede" value="{{ $sede->nombre_sede }}" required>
            </div>
            <div class="form-group">
                <label>Dirección</label>
                <input class="form-control" type="text" name="direccion" value="{{ $sede->direccion }}">
            </div>
             <div class="form-group">
                <label>Teléfono</label>
                <input class="form-control" type="text" name="telefono" value="{{ $sede->telefono }}">
            </div>
            <div class="text-right">
                <a href="{{ route('sedes.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Sede</button>
            </div>
        </form>
    </div>
</div>
@endsection