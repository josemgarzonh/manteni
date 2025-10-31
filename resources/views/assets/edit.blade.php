@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Editar Activo: {{ $asset->nombre_equipo }}</h2>
    <div class="pd-20">
        <form action="{{ route('assets.update', $asset->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Tipo de Activo</label>
                <select class="form-control" name="asset_type_id" required>
                    @foreach ($assetTypes as $type)
                        <option value="{{ $type->id }}" {{ $asset->asset_type_id == $type->id ? 'selected' : '' }}>{{ $type->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Tipo Específico (Ej: Desfibrilador, Laringoscopio)</label>
                <input class="form-control" list="specific_types_list" name="specific_type" id="specific_type" value="{{ $asset->specific_type }}">
                <datalist id="specific_types_list">
                    <option value="Contador de Colonias">
                    <option value="Tensiómetro">
                    <option value="Bomba de Infusión">
                    <option value="Monitor de Signos Vitales">
                    <option value="Maquina de Anestesia">
                    <option value="Lampara Quirúrgica">
                    <option value="Mesa de Cirugía">
                    <option value="Aspirador de Fluidos">
                    <option value="Desfibrilador">
                    <option value="Laringoscopio">
                    <option value="Pulsioxímetro">
                    <option value="Microscopio">
                    <option value="Pipeta Automática">
                    <option value="Centrífuga">
                </datalist>
            </div>

            <div class="form-group">
                <label>Sede</label>
                <select class="form-control" name="sede_id" id="sede_id" required>
                    @foreach ($sedes as $sede)
                        <option value="{{ $sede->id }}" {{ $asset->sede_id == $sede->id ? 'selected' : '' }}>{{ $sede->nombre_sede }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Servicio</label>
                <select class="form-control" name="servicio_id" id="servicio_id">
                    <option value="">Cargando...</option>
                </select>
            </div>

            <div class="form-group">
                <label>Zona</label>
                <select class="form-control" name="zona_id" id="zona_id">
                    <option value="">Cargando...</option>
                </select>
            </div>

            <div class="form-group">
                <label>Nombre del Equipo o Activo</label>
                <input class="form-control" type="text" name="nombre_equipo" value="{{ $asset->nombre_equipo }}" required>
            </div>
            
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Marca</label>
                        <input class="form-control" type="text" name="marca" value="{{ $asset->marca }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Modelo</label>
                        <input class="form-control" type="text" name="modelo" value="{{ $asset->modelo }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Serie</label>
                        <input class="form-control" type="text" name="serie" value="{{ $asset->serie }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Activo Fijo</label>
                        <input class="form-control" type="text" name="activo_fijo" value="{{ $asset->activo_fijo }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha de Adquisición</label>
                        <input class="form-control" type="date" name="fecha_adquisicion" value="{{ $asset->fecha_adquisicion }}">
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label>Cambiar Imagen del Activo</label>
                <input type="file" name="imagen_url" class="form-control-file form-control height-auto" accept="image/*" capture>
                @if($asset->imagen_url)
                    <small>Imagen actual:</small>
                    <img src="{{ asset('storage/' . $asset->imagen_url) }}" alt="Imagen actual" class="img-thumbnail mt-2" width="150">
                @endif
            </div>

            <div class="text-right">
                 <a href="{{ route('assets.index') }}" class="btn btn-secondary">Cancelar</a>
                 <button type="submit" class="btn btn-primary">Actualizar Activo</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sedeSelect = document.getElementById('sede_id');
    const servicioSelect = document.getElementById('servicio_id');
    const zonaSelect = document.getElementById('zona_id');

    const currentServicioId = {{ $asset->servicio_id ?? 'null' }};
    const currentZonaId = {{ $asset->zona_id ?? 'null' }};

    function fetchAndPopulate(url, selectElement, defaultOptionText, selectedId = null) {
        selectElement.innerHTML = `<option value="">Cargando...</option>`;
        
        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                selectElement.innerHTML = `<option value="">${defaultOptionText}</option>`;
                data.forEach(item => {
                    const option = new Option(item.nombre_servicio || item.nombre_zona, item.id);
                    if(item.id == selectedId) {
                        option.selected = true;
                    }
                    selectElement.add(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                selectElement.innerHTML = `<option value="">Error al cargar</option>`;
            });
    }

    function initializeDropdowns() {
        const sedeId = sedeSelect.value;
        if (sedeId) {
            fetchAndPopulate(`{{ url('api/sedes') }}/${sedeId}/servicios`, servicioSelect, 'Seleccione un servicio...', currentServicioId);
            fetchAndPopulate(`{{ url('api/sedes') }}/${sedeId}/zonas`, zonaSelect, 'Seleccione una zona...', currentZonaId);
        } else {
            servicioSelect.innerHTML = '<option value="">Seleccione una sede primero...</option>';
            zonaSelect.innerHTML = '<option value="">Seleccione una sede primero...</option>';
        }
    }

    // Initial load
    initializeDropdowns();

    // Event listener for changes
    sedeSelect.addEventListener('change', function() {
        const sedeId = this.value;
        fetchAndPopulate(`{{ url('api/sedes') }}/${sedeId}/servicios`, servicioSelect, 'Seleccione un servicio...');
        fetchAndPopulate(`{{ url('api/sedes') }}/${sedeId}/zonas`, zonaSelect, 'Seleccione una zona...');
    });
});
</script>
@endpush
@endsection