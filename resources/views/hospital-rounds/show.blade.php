@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <div class="pd-20">
        <h2 class="h4">Detalles de la Ronda Hospitalaria #{{ $hospitalRound->id }}</h2>
    </div>
    <div class="pd-20">
        <div class="row">
            <div class="col-md-6">
                <h5>Información General</h5>
                <p><strong>Fecha y Hora:</strong> {{ $hospitalRound->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>Realizada por:</strong> {{ $hospitalRound->user->name }}</p>
                <p><strong>Sede:</strong> {{ $hospitalRound->sede->nombre_sede ?? 'N/A' }}</p>
                <p><strong>Servicio:</strong> {{ $hospitalRound->servicio->nombre_servicio ?? 'N/A' }}</p>
                <p><strong>Zona/Lugar:</strong> {{ $hospitalRound->zona->nombre_zona ?? 'N/A' }}</p>
                <p><strong>Observaciones Generales:</strong> {{ $hospitalRound->observations ?? 'Ninguna.' }}</p>
            </div>
            <div class="col-md-6">
                <h5>Falla Reportada</h5>
                @if($hospitalRound->found_failures)
                    <p><strong>Equipo:</strong> {{ $hospitalRound->asset->nombre ?? 'No especificado' }} (Placa: {{ $hospitalRound->asset->placa_inventario ?? 'N/A' }})</p>
                    <p><strong>Descripción de la Falla:</strong> {{ $hospitalRound->failure_description }}</p>
                    
                    @if($hospitalRound->image_url)
                        <p><strong>Fotografía Adjunta:</strong></p>
                        <img src="{{ Storage::url($hospitalRound->image_url) }}" alt="Foto de la falla" class="img-fluid" style="max-width: 300px; border-radius: 5px;">
                    @endif

                    @if($hospitalRound->maintenance_request_id)
                        <p class="mt-3">
                            <strong>Reporte Generado:</strong> 
                            <a href="{{ route('maintenance-requests.show', $hospitalRound->maintenance_request_id) }}" class="btn btn-sm btn-outline-primary">Ver Solicitud #{{ $hospitalRound->maintenance_request_id }}</a>
                        </p>
                    @endif
                @else
                    <p>No se reportaron fallas en esta ronda.</p>
                @endif
            </div>
        </div>

        <hr>

        <h5>Responsable del Servicio</h5>
        <p><strong>Nombre:</strong> {{ $hospitalRound->responsible_name }}</p>
        @if($hospitalRound->responsible_signature)
            <p><strong>Firma:</strong></p>
            <img src="{{ Storage::url($hospitalRound->responsible_signature) }}" alt="Firma" style="background-color: #f8f9fa; border: 1px solid #dee2e6; max-width: 250px;">
        @endif

        <div class="mt-4">
            <a href="{{ route('hospital-rounds.index') }}" class="btn btn-secondary">Volver al Historial</a>
        </div>
    </div>
</div>
@endsection