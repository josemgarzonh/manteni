@extends('layouts.app')
@section('content')
<div class="card-box mb-30 pd-20">
    <h2 class="h4">Resultados del Protocolo de Baja</h2>
    <p>Evaluación para el equipo: <strong>{{ $protocol->asset->nombre_equipo }}</strong></p>

    <div class="alert alert-info mt-4" role="alert">
        <h4 class="alert-heading">Puntuación Final (V): {{ number_format($protocol->score_V_final, 2) }}</h4>
        <hr>
        <p class="mb-0"><strong>Recomendación:</strong> {{ $protocol->recommendation }}</p>
    </div>

    <a href="{{ route('assets.index') }}" class="btn btn-secondary mt-3">Volver al Inventario</a>
</div>
@endsection