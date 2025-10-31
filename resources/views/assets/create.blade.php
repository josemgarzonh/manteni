@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Registrar Nuevo Activo</h2>
    <div class="pd-20">
        <form action="{{ route('assets.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nombre del Equipo o Activo</label>
                <input class="form-control" type="text" name="nombre_equipo" value="{{ old('nombre_equipo') }}" required>
            </div>

            <div class="form-group">
                <label>Tipo de Activo</label>
                <select class="form-control" name="asset_type_id" required>
                    <option value="" disabled selected>Selecciona un tipo...</option>
                    @foreach ($assetTypes as $type)
                        <option value="{{ $type->id }}" {{ old('asset_type_id') == $type->id ? 'selected' : '' }}>{{ $type->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Sede</label>
                <select class="form-control" name="sede_id" id="sede_id" required>
                    <option value="" disabled selected>Selecciona una sede...</option>
                    @foreach ($sedes as $sede)
                        <option value="{{ $sede->id }}" {{ old('sede_id') == $sede->id ? 'selected' : '' }}>{{ $sede->nombre_sede }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Zona</label>
                <select class="form-control" name="zona_id" id="zona_id" required>
                    <option value="" disabled selected>Selecciona una sede primero...</option>
                </select>
            </div>
            
            <div class="form-group">
                    <label>Tipo Específico (Ej: Desfibrilador, Laringoscopio)</label>
                    <input class="form-control" list="specific_types_list" name="specific_type" id="specific_type" value="{{ old('specific_type') }}">
                    <datalist id="specific_types_list">
                        {{-- Lista de la primera imagen --}}
                        <option value="contador de colonias">
                        <option value="tensiómetro">
                        <option value="tensiómetro de pared">
                        <option value="bomba de infusión">
                        <option value="monitor de signos vitales">
                        <option value="maquina de anestesia">
                        <option value="lampara quirúrgica">
                        <option value="mesa de cirugía">
                        <option value="aspirador de fluidos">
                        <option value="desfibrilador">
                        <option value="laringoscopio">
                        <option value="pulsioxímetro">
                        {{-- Lista de la segunda imagen --}}
                        <option value="microscopio">
                        <option value="pipeta automática">
                        <option value="centrífuga">
                        <option value="equipo de química">
                        <option value="equipo de hematología">
                        <option value="agitador de mazzini">
                        <option value="baño serológico">
                        <option value="nevera">
                        <option value="termohigrómetro">
                        <option value="incubadora lab">
                        <option value="cabina de flujo laminar">
                        <option value="equipo de electrolitos">
                        <option value="microcentrífuga">
                    </datalist>
                </div>
                            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Marca</label>
                        <input class="form-control" type="text" name="marca" value="{{ old('marca') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Modelo</label>
                        <input class="form-control" type="text" name="modelo" value="{{ old('modelo') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Serie</label>
                        <input class="form-control" type="text" name="serie" value="{{ old('serie') }}">
                    </div>
                </div>
            </div>

            <div class="text-right">
                 <a href="{{ route('assets.index') }}" class="btn btn-secondary">Cancelar</a>
                 <button type="submit" class="btn btn-primary">Guardar y Continuar</button>
            </div>
        </form>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sedeSelect = document.getElementById('sede_id');
    const zonaSelect = document.getElementById('zona_id');

    function fetchZonas(sedeId) {
        zonaSelect.innerHTML = '<option value="">Cargando...</option>';

        if (!sedeId) {
            zonaSelect.innerHTML = '<option value="" disabled selected>Selecciona una sede primero...</option>';
            return;
        }

        // --- CAMBIO IMPORTANTE AQUÍ ---
        // Usamos la función route() de Laravel para generar la URL correcta
        const url = "{{ route('api.sedes.zonas', ['sede' => ':sedeId']) }}".replace(':sedeId', sedeId);

        // Fetch Zonas
        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al cargar las zonas. Código: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                zonaSelect.innerHTML = '<option value="" disabled selected>Selecciona una zona...</option>';
                if (data.length > 0) {
                    data.forEach(function(zona) {
                        const option = new Option(zona.nombre_zona, zona.id);
                        zonaSelect.add(option);
                    });
                } else {
                     zonaSelect.innerHTML = '<option value="" disabled selected>No hay zonas para esta sede</option>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                zonaSelect.innerHTML = '<option value="" disabled selected>Error al cargar zonas</option>';
            });
    }

    sedeSelect.addEventListener('change', function() {
        fetchZonas(this.value);
    });

    // If a sede is already selected on page load (e.g., due to old form data), fetch its zonas
    if (sedeSelect.value) {
        fetchZonas(sedeSelect.value);
    }
});
</script>
@endpush
@endsection

