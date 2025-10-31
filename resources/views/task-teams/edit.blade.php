@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Editar Equipo de Tarea: {{ $taskTeam->nombre_equipo }}</h2>
    <div class="pd-20">
        <form action="{{ route('task-teams.update', $taskTeam->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nombre del Equipo</label>
                <input class="form-control" type="text" name="nombre_equipo" value="{{ $taskTeam->nombre_equipo }}" required>
            </div>

            <div class="form-group">
                <label>Asignar Miembros (Técnicos/Ingenieros)</label>
                <select class="custom-select2 form-control" name="users[]" multiple="multiple" style="width: 100%;">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $taskTeam->users->contains($user->id) ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Asignar Zonas</label>
                <select class="custom-select2 form-control" name="zonas[]" multiple="multiple" style="width: 100%;">
                    @foreach ($zonas as $zona)
                        <option value="{{ $zona->id }}" {{ $taskTeam->zonas->contains($zona->id) ? 'selected' : '' }}>{{ $zona->nombre_zona }} (Sede: {{ $zona->sede->nombre_sede ?? 'N/A' }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Asignar Servicios</label>
                <select class="custom-select2 form-control" name="servicios[]" multiple="multiple" style="width: 100%;">
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}" {{ $taskTeam->services->contains($servicio->id) ? 'selected' : '' }}>{{ $servicio->nombre_servicio }} (Sede: {{ $servicio->sede->nombre_sede ?? 'N/A' }})</option>
                    @endforeach
                </select>
            </div>

            <div class="text-right">
                <a href="{{ route('task-teams.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Equipo</button>
            </div>
        </form>
    </div>
</div>
@endsection