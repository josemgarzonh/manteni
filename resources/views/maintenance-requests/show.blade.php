@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card-box mb-30 pd-20">
            <h4 class="h4 text-blue">Detalle de Solicitud No. {{ $request->id }}</h4>
            <p class="mb-30">Recibida el: {{ $request->created_at->format('d/m/Y H:i A') }}</p>

            <table class="table table-bordered">
                <tr>
                    <th>Solicitante</th>
                    <td>{{ $request->user->name ?? $request->solicitante_nombre }}</td>
                </tr>
                <tr>
                    <th>Ubicación</th>
                    <td>{{ $request->ubicacion_texto }}</td>
                </tr>
                @if($request->asset)
                <tr>
                    <th>Equipo Relacionado</th>
                    <td>{{ $request->asset->nombre_equipo }} (ID: {{ $request->asset->id }})</td>
                </tr>
                @endif
                <tr>
                    <th>Descripción de la Falla</th>
                    <td>{{ $request->descripcion }}</td>
                </tr>
            </table>

            @if($request->imagen_url)
                <h5 class="h5 mt-30">Imagen Adjunta</h5>
                <img src="{{ asset('storage/' . $request->imagen_url) }}" class="img-fluid" alt="Imagen de la falla">
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="card-box mb-30 pd-20">
            <h5 class="h5 mb-20">Asignar Tarea</h5>
            <form action="{{ route('maintenance-requests.assign', $request->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Asignar a Técnico:</label>
                    <select name="assigned_to" class="form-control" required>
                        <option value="" disabled selected>Seleccione un técnico...</option>
                        @foreach($technicians as $technician)
                            <option value="{{ $technician->id }}">{{ $technician->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Estado Actual:</label>
                    <p><strong><span class="badge badge-warning" style="font-size: 1rem;">{{ $request->estado }}</span></strong></p>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Asignar y Notificar</button>
            </form>
        </div>
    </div>
</div>
@endsection