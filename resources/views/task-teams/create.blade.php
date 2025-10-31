@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Crear Nuevo Equipo de Tarea</h2>
    <div class="pd-20">
        <form action="{{ route('task-teams.store') }}" method="POST">
            @csrf
            <div class="form-group">
                
                <label>Nombre del Equipo</label>
                <input class="form-control" type="text" name="nombre_equipo" required>
            </div>

            <div class="form-group">
                <label>Asignar Miembros (Técnicos/Ingenieros)</label>
                <select class="custom-select2 form-control" name="users[]" multiple="multiple" style="width: 100%;">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Asignar Sedes (para notificaciones generales de esa sede)</label>
                <select class="custom-select2 form-control" name="sedes[]" multiple="multiple" style="width: 100%;">
                    @foreach ($sedes as $sede)
                        <option value="{{ $sede->id }}">{{ $sede->nombre_sede }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Asignar Zonas</label>
                <select class="custom-select2 form-control" name="zonas[]" multiple="multiple" style="width: 100%;">
                    @foreach ($zonas as $zona)
                        <option value="{{ $zona->id }}">{{ $zona->nombre_zona }} (Sede: {{ $zona->sede->nombre_sede ?? 'N/A' }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Asignar Servicios Específicos</label>
                <select class="custom-select2 form-control" name="servicios[]" multiple="multiple" style="width: 100%;">
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ $servicio->nombre_servicio }} (Sede: {{ $servicio->sede->nombre_sede ?? 'N/A' }})</option>
                    @endforeach
                </select>
            </div>

            <div class="text-right">
                <a href="{{ route('task-teams.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Equipo</button>
            </div>
        </form>
    </div>
</div>
@endsection