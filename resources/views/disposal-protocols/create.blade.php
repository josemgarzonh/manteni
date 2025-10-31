@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Protocolo de Baja para: {{ $asset->nombre_equipo }}</h2>
    <div class="pd-20">
        <form action="{{ route('disposal-protocols.store', $asset->id) }}" method="POST">
            @csrf
            {{-- Aquí irían todas las preguntas del formulario con inputs de tipo number (min=0, max=10) --}}
            {{-- Por ejemplo, para la evaluación técnica --}}
            <h5 class="h5 mb-20">Evaluación Técnica (T)</h5>
            <div class="form-group">
                <label>Edad del equipo (0=muy viejo, 10=nuevo)</label>
                <input type="number" name="T_edad" class="form-control" min="0" max="10" required>
            </div>
            {{-- ... Repetir para los otros 15+ campos ... --}}

            <h5 class="h5 mb-20 mt-3">Evaluación Económica (E)</h5>
             <div class="form-group">
                <label>Costo Anual de Mantenimiento ($)</label>
                <input type="number" step="0.01" name="E_costo_mantenimiento" class="form-control" required>
            </div>
             <div class="form-group">
                <label>Costo de Sustitución (Reemplazo) ($)</label>
                <input type="number" step="0.01" name="E_costo_sustitucion" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Calcular y Guardar Evaluación</button>
        </form>
    </div>
</div>
@endsection