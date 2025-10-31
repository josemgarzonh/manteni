@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Reportar una Falla o Solicitar Mantenimiento</h2>
    <div class="pd-20">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('maintenance-requests.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- SECCIÓN DE BÚSQUEDA Y SELECCIÓN DE EQUIPO --}}
            <div class="row align-items-center pd-10 mb-4" style="background-color: #f0f0f0; border-radius: 5px;">
                <div class="col-md-8">
                    <h5 class="h5 mb-20">1. Seleccione el Equipo</h5>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="sede_id">SEDE:</label>
                            <select class="form-control" name="sede_id" id="sede_id" required>
                                <option value="" disabled selected>Selecciona una sede...</option>
                                @foreach ($sedes as $sede)
                                    <option value="{{ $sede->id }}">{{ $sede->nombre_sede }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="servicio_id">SERVICIO:</label>
                            <select class="form-control" name="servicio_id" id="servicio_id" required>
                                <option value="" disabled selected>Selecciona una sede primero...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group position-relative">
                        <label for="assetSearch">BÚSQUEDA RÁPIDA DE EQUIPO:</label>
                        <div class="input-group">
                             <input type="text" id="assetSearch" class="form-control" placeholder="Buscar por nombre, serie, etc.">
                        </div>
                        <div id="searchResults" class="list-group position-absolute w-100" style="z-index: 1000;"></div>
                    </div>
                </div>
                <div class="col-12 form-group">
                    <label for="asset_id">EQUIPO:</label>
                    <select class="form-control" name="asset_id" id="asset_id" required>
                        <option value="" disabled selected>Selecciona un servicio primero...</option>
                    </select>
                 </div>
            </div>

            <hr>

            {{-- SECCIÓN DE DETALLES DE LA FALLA --}}
            <h5 class="h5 mb-20">2. Describa la Falla</h5>
            @guest
            <div class="form-group">
                <label>Su Nombre Completo</label>
                <input class="form-control" type="text" name="solicitante_nombre" required>
            </div>
            @endguest

            <div class="form-group">
                <label>Ubicación Específica (si es diferente a la del equipo)</label>
                <input class="form-control" type="text" name="ubicacion_texto" placeholder="Ej: Pasillo de urgencias, piso 2..." required>
            </div>

            <div class="form-group">
                <label>Descripción detallada de la falla</label>
                <textarea class="form-control" name="descripcion" required></textarea>
            </div>

            <div class="form-group">
                <label>Adjuntar una Imagen (Opcional)</label>
                <input type="file" name="imagen" class="form-control-file form-control height-auto">
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sedeSelect = document.getElementById('sede_id');
    const servicioSelect = document.getElementById('servicio_id');
    const assetSelect = document.getElementById('asset_id');
    const assetSearchInput = document.getElementById('assetSearch');
    const searchResultsContainer = document.getElementById('searchResults');

    // Función para cargar servicios de una sede
    function fetchServicios(sedeId, selectedServicioId = null) {
        if (!sedeId) {
            servicioSelect.innerHTML = '<option value="" disabled selected>Selecciona una sede...</option>';
            assetSelect.innerHTML = '<option value="" disabled selected>Selecciona un servicio...</option>';
            return;
        }
        fetch(`{{ url('api/sedes') }}/${sedeId}/servicios`)
            .then(response => response.json())
            .then(data => {
                servicioSelect.innerHTML = '<option value="" disabled selected>Seleccione un servicio...</option>';
                data.forEach(servicio => {
                    const option = new Option(servicio.nombre_servicio, servicio.id);
                    servicioSelect.add(option);
                });
                if (selectedServicioId) {
                    servicioSelect.value = selectedServicioId;
                    servicioSelect.dispatchEvent(new Event('change'));
                }
            });
    }

    // Función para cargar equipos de un servicio
    function fetchAssets(servicioId) {
        if (!servicioId) {
            assetSelect.innerHTML = '<option value="" disabled selected>Selecciona un servicio...</option>';
            return;
        }
        fetch(`{{ url('api/servicios') }}/${servicioId}/assets`)
            .then(response => response.json())
            .then(data => {
                assetSelect.innerHTML = '<option value="" disabled selected>Seleccione un equipo...</option>';
                data.forEach(asset => {
                    const option = new Option(`${asset.nombre_equipo} (Serie: ${asset.serie || 'N/A'})`, asset.id);
                    assetSelect.add(option);
                });
            });
    }

    // Función para rellenar los campos cuando se selecciona un equipo de la búsqueda rápida
    function selectAndFillAsset(asset) {
        sedeSelect.value = asset.sede_id;
        fetchServicios(asset.sede_id, asset.servicio_id);
        // Pequeña demora para asegurar que los servicios se cargan antes de los equipos
        setTimeout(() => {
            fetch(`{{ url('api/servicios') }}/${asset.servicio_id}/assets`)
                .then(response => response.json())
                .then(data => {
                    assetSelect.innerHTML = '<option value="" disabled selected>Seleccione un equipo...</option>';
                    data.forEach(a => {
                        const option = new Option(`${a.nombre_equipo} (Serie: ${a.serie || 'N/A'})`, a.id);
                        assetSelect.add(option);
                    });
                    assetSelect.value = asset.id;
                });
        }, 500);
    }

    // Event Listeners
    sedeSelect.addEventListener('change', () => fetchServicios(sedeSelect.value));
    servicioSelect.addEventListener('change', () => fetchAssets(servicioSelect.value));

    // Búsqueda rápida
    assetSearchInput.addEventListener('keyup', function() {
        const query = this.value;
        if (query.length < 3) {
            searchResultsContainer.innerHTML = '';
            return;
        }
        fetch(`{{ url('api/assets/search') }}?q=${query}`)
            .then(response => response.json())
            .then(data => {
                searchResultsContainer.innerHTML = '';
                data.forEach(asset => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.classList.add('list-group-item', 'list-group-item-action');
                    item.textContent = `${asset.nombre_equipo} - ${asset.serie || 'S/S'} (${asset.sede.nombre_sede})`;
                    item.addEventListener('click', (e) => {
                        e.preventDefault();
                        selectAndFillAsset(asset);
                        searchResultsContainer.innerHTML = '';
                        assetSearchInput.value = '';
                    });
                    searchResultsContainer.appendChild(item);
                });
            });
    });
});
</script>
@endpush
@endsection