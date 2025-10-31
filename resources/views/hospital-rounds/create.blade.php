@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Registrar Nueva Ronda Hospitalaria</h2>
    <div class="pd-20">
        <form action="{{ route('hospital-rounds.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="asset_search_universal" class="font-weight-bold">Búsqueda Rápida de Equipo:</label>
                <input type="text" id="asset_search_universal" class="form-control" placeholder="Buscar por Nombre, Serie o Placa para autocompletar...">
                <div id="asset_search_results_universal"></div>
            </div>
            <hr>

            <h5 class="mb-3">Ubicación de la Ronda</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="sede_id">Sede:</label>
                        <select class="form-control" id="sede_id" name="sede_id" required>
                            <option value="">Seleccione una Sede</option>
                            @foreach ($sedes as $sede)
                                <option value="{{ $sede->id }}">{{ $sede->nombre_sede }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="servicio_id">Servicio:</label>
                        <select class="form-control" id="servicio_id" name="servicio_id" required disabled>
                            <option value="">Seleccione una Sede primero</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="zona_id">Lugar / Zona (Opcional):</label>
                        <select class="form-control" id="zona_id" name="zona_id" disabled>
                            <option value="">Seleccione una Sede primero</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="asset_id_select">Equipo:</label>
                        <select class="form-control" id="asset_id_select" disabled>
                            <option value="">Seleccione un Servicio primero</option>
                        </select>
                    </div>
                </div>
                
                
            </div>
            <hr>

            <h5 class="mb-3">Reporte de Fallas</h5>
            <div class="form-group">
                <label>¿Se encontraron fallas?</label>
                <div>
                    <input type="radio" id="fallas_si" name="found_failures" value="1" required> <label for="fallas_si" class="mr-3">Sí</label>
                    <input type="radio" id="fallas_no" name="found_failures" value="0" checked> <label for="fallas_no">No</label>
                </div>
            </div>

            <div id="failure_details_container" style="display: none; border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 5px;">
                <p><strong>Equipo a reportar:</strong> <span id="selected_asset_name" class="text-primary font-weight-bold">Ninguno</span></p>
                <input type="hidden" id="asset_id" name="asset_id">
                <input type="hidden" id="ubicacion_texto_hidden" name="ubicacion_texto_hidden">

                <div class="form-group">
                    <label for="failure_description">Descripción de la Falla:</label>
                    <textarea name="failure_description" id="failure_description" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Adjuntar Fotografía (Opcional)</label>
                    <input type="file" name="image" id="image" class="form-control-file">
                </div>
            </div>
            <hr>

            <div class="form-group">
                <label for="observations">Observaciones Generales de la Ronda</label>
                <textarea name="observations" id="observations" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="responsible_name">Nombre del Responsable del Servicio (o quien informa):</label>
                <input type="text" name="responsible_name" id="responsible_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Firma del Responsable:</label>
                <div id="signature-pad" class="signature-pad" style="max-width: 400px; touch-action: none;">
                    <canvas style="border: 1px solid #ccc; border-radius: 5px; width: 100%; height: 200px;"></canvas>
                    <a href="#" class="btn btn-sm btn-outline-danger mt-2" data-action="clear">Limpiar</a>
                </div>
                <input type="hidden" name="responsible_signature" id="responsible_signature">
            </div>
            
            <button type="submit" class="btn btn-primary">Guardar Ronda</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Referencias a elementos del DOM ---
    const sedeSelect = document.getElementById('sede_id');
    const servicioSelect = document.getElementById('servicio_id');
    const zonaSelect = document.getElementById('zona_id');
    const assetSelect = document.getElementById('asset_id_select'); // Nuevo select de equipo
    const assetIdInput = document.getElementById('asset_id'); // Hidden input para el ID final
    const ubicacionHidden = document.getElementById('ubicacion_texto_hidden');
    const selectedAssetName = document.getElementById('selected_asset_name');
    const searchInputUniversal = document.getElementById('asset_search_universal');
    const searchResultsUniversal = document.getElementById('asset_search_results_universal');

    // --- Funciones para popular Selects ---
    const fetchAndPopulate = (url, selectElement, defaultOption) => {
        selectElement.innerHTML = `<option value="">Cargando...</option>`;
        selectElement.disabled = true;
        return fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                selectElement.innerHTML = `<option value="">${defaultOption}</option>`;
                data.forEach(item => {
                    const name = item.nombre_servicio || item.nombre_zona || item.nombre_equipo;
                    selectElement.innerHTML += `<option value="${item.id}">${name}</option>`;
                });
                selectElement.disabled = false;
            })
            .catch(error => {
                console.error('Fetch error:', error);
                selectElement.innerHTML = `<option value="">Error al cargar</option>`;
            });
    };

    // --- Event Listeners ---
    sedeSelect.addEventListener('change', function() {
        const sedeId = this.value;
        // Limpiar selects dependientes
        servicioSelect.innerHTML = '<option value="">Seleccione una Sede</option>';
        zonaSelect.innerHTML = '<option value="">Seleccione una Sede</option>';
        assetSelect.innerHTML = '<option value="">Seleccione un Servicio</option>';
        servicioSelect.disabled = zonaSelect.disabled = assetSelect.disabled = true;

        if (sedeId) {
            fetchAndPopulate(`{{ url('/api/sedes') }}/${sedeId}/servicios`, servicioSelect, 'Seleccione un Servicio');
            fetchAndPopulate(`{{ url('/api/sedes') }}/${sedeId}/zonas`, zonaSelect, 'Seleccione una Zona');
        }
    });

    servicioSelect.addEventListener('change', function() {
        const servicioId = this.value;
        assetSelect.innerHTML = '<option value="">Seleccione un Servicio</option>';
        assetSelect.disabled = true;
        if (servicioId) {
            fetchAndPopulate(`{{ url('/api/servicios') }}/${servicioId}/assets`, assetSelect, 'Seleccione un Equipo');
        }
    });

    // Cuando se elige un equipo del NUEVO dropdown
    assetSelect.addEventListener('change', function() {
        const assetId = this.value;
        const assetName = this.options[this.selectedIndex].text;
        if (assetId) {
            selectAsset(assetId, assetName);
        }
    });

    // --- Lógica de Búsqueda Rápida ---
    searchInputUniversal.addEventListener('keyup', function() {
        const query = this.value;
        if (query.length < 3) {
            searchResultsUniversal.innerHTML = '';
            return;
        }
        fetch(`{{ url('/api/assets/search') }}?q=${query}`)
            .then(response => response.json())
            .then(data => {
                searchResultsUniversal.innerHTML = '';
                if (data.length > 0) {
                    const list = document.createElement('ul');
                    list.className = 'list-group position-absolute w-100';
                    list.style.zIndex = 1000;
                    data.forEach(asset => {
                        const item = document.createElement('li');
                        item.className = 'list-group-item list-group-item-action';
                        item.style.cursor = 'pointer';
                        item.innerText = `${asset.nombre_equipo} (Serie: ${asset.serie || 'N/A'}) - ${asset.sede.nombre_sede}`;
                        item.addEventListener('click', () => {
                            // Acción al hacer clic en un resultado de búsqueda
                            searchResultsUniversal.innerHTML = '';
                            searchInputUniversal.value = asset.nombre_equipo; // <-- Mantiene el nombre en el input
                            autofillFormFromAsset(asset.id);
                        });
                        list.appendChild(item);
                    });
                    searchResultsUniversal.appendChild(list);
                }
            });
    });
    // Ocultar resultados si se hace clic fuera
    document.addEventListener('click', (e) => {
        if (!searchResultsUniversal.contains(e.target)) searchResultsUniversal.innerHTML = '';
    });

    // --- Funciones de Lógica Central ---
    const selectAsset = (assetId, assetName) => {
        assetIdInput.value = assetId;
        selectedAssetName.innerText = assetName;
        const ubicacionCompleta = `${sedeSelect.options[sedeSelect.selectedIndex].text} / ${servicioSelect.options[servicioSelect.selectedIndex].text}`;
        ubicacionHidden.value = ubicacionCompleta;
    };

    const autofillFormFromAsset = (assetId) => {
        fetch(`{{ url('/api/assets') }}/${assetId}`)
            .then(response => response.json())
            .then(assetDetails => {
                selectAsset(assetDetails.id, assetDetails.nombre_equipo);
                
                sedeSelect.value = assetDetails.sede_id;
                // Dispara el evento change para cargar los selects dependientes
                sedeSelect.dispatchEvent(new Event('change'));

                // Usa un pequeño retardo para dar tiempo a que se carguen los datos
                setTimeout(() => {
                    servicioSelect.value = assetDetails.servicio_id;
                    servicioSelect.dispatchEvent(new Event('change'));
                    setTimeout(() => {
                        assetSelect.value = assetDetails.id;
                        zonaSelect.value = assetDetails.zona_id;
                    }, 300);
                }, 300);
            });
    };

    // --- Lógica del Formulario (Fallas y Firma) ---
    const failureRadios = document.querySelectorAll('input[name="found_failures"]');
    const failureContainer = document.getElementById('failure_details_container');
    failureRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            failureContainer.style.display = this.value === '1' ? 'block' : 'none';
        });
    });

    const canvas = document.querySelector("canvas");
    const signaturePad = new SignaturePad(canvas);
    const clearButton = document.querySelector("[data-action=clear]");
    const form = document.querySelector("form");

    function resizeCanvas() {
        const ratio =  Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }
    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();
    
    clearButton.addEventListener("click", function (event) {
        event.preventDefault();
        signaturePad.clear();
    });

    form.addEventListener("submit", function (event) {
        if (!signaturePad.isEmpty()) {
            document.getElementById('responsible_signature').value = signaturePad.toDataURL();
        }
    });
});
</script>
@endpush