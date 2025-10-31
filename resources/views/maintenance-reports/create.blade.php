@extends('layouts.app')

@section('content')

<div class="card-box mb-30">
    <h2 class="h4 pd-20">Nuevo Reporte de Mantenimiento</h2>
    <div class="pd-20">
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <h4 class="alert-heading">¡Error al procesar el formulario!</h4>
                <p>Por favor, corrige los siguientes errores:</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- === INICIO DE LA MODIFICACIÓN === --}}
        <form id="createReportForm" action="{{ route('maintenance-reports.store') }}" method="POST" enctype="multipart/form-data">
        {{-- === FIN DE LA MODIFICACIÓN === --}}
            @csrf
            <input type="hidden" name="request_id" value="{{ $requestId ?? '' }}">

            {{-- SECCIÓN DE BÚSQUEDA Y SELECCIÓN --}}
            <div class="row align-items-center pd-10" style="background-color: #f0f0f0; border-radius: 5px;">
                <div class="col-md-8">
                    <h5 class="h5 mb-20">Información del Equipo y Servicio</h5>
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label for="sede_id">SEDE:</label>
                            <select class="form-control" name="sede_id" id="sede_id" required>
                                <option value="" disabled selected>Selecciona una sede...</option>
                                @foreach ($sedes as $sede)
                                    <option value="{{ $sede->id }}" {{ (isset($selectedAsset) && $selectedAsset->sede_id == $sede->id) ? 'selected' : '' }}>
                                        {{ $sede->nombre_sede }}
                                    </option>
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
                        <label for="assetSearch">BUSCAR EQUIPO:</label>
                        <div class="input-group">
                             <input type="text" id="assetSearch" class="form-control" placeholder="Buscar por nombre, serie, etc.">
                             <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button">BUSCAR</button>
                             </div>
                        </div>
                        <div id="searchResults" class="list-group position-absolute w-100" style="z-index: 1000;"></div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-2">
                 <div class="col-12 form-group">
                    <label for="asset_id">EQUIPO:</label>
                    <select class="form-control" name="asset_id" id="asset_id" required>
                        <option value="" disabled selected>Selecciona un servicio primero...</option>
                    </select>
                 </div>
            </div>

            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>nombre</th>
                        <th>marca</th>
                        <th>modelo</th>
                        <th>serie</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="asset_nombre"></td>
                        <td id="asset_marca"></td>
                        <td id="asset_modelo"></td>
                        <td id="asset_serie"></td>
                    </tr>
                </tbody>
            </table>

            <hr>

            <h5 class="h5 mb-20 mt-3">Checklist de Descripción del Servicio</h5>
            <div class="row">
                @foreach (collect($checklistItems)->chunk(ceil(count($checklistItems) / 3)) as $chunk)
                    <div class="col-md-4">
                        @foreach ($chunk as $item)
                            <div class="form-group border-bottom pb-2">
                                <label class="font-weight-bold d-block mb-2">{{ $item }}</label>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="si_{{ Str::slug($item) }}" name="checklist[{{ $item }}]" class="custom-control-input" value="si" checked>
                                    <label class="custom-control-label" for="si_{{ Str::slug($item) }}">SI</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="no_{{ Str::slug($item) }}" name="checklist[{{ $item }}]" class="custom-control-input" value="no">
                                    <label class="custom-control-label" for="no_{{ Str::slug($item) }}">NO</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="na_{{ Str::slug($item) }}" name="checklist[{{ $item }}]" class="custom-control-input" value="na">
                                    <label class="custom-control-label" for="na_{{ Str::slug($item) }}">N.A.</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>

            <hr>
            
            <div class="form-group">
                <label>Tipo de Mantenimiento</label>
                <select class="form-control" name="tipo_mantenimiento" required>
                    <option value="preventivo">Preventivo</option>
                    <option value="correctivo" selected>Correctivo</option>
                    <option value="mejorativo">Mejorativo</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
            
            <h5 class="h5 mb-20 mt-3">Detalles Adicionales del Servicio</h5>
            <div class="form-group">
                <label>Observaciones</label>
                <textarea class="form-control" name="observaciones"></textarea>
            </div>
            
            <div class="form-group">
                <h5 class="h5 mb-20 mt-3">Repuestos Utilizados / Solicitados</h5>
                <div id="spare-parts-container">
                    <!-- Los repuestos se añadirán aquí dinámicamente -->
                </div>
                <button type="button" id="add-spare-part" class="btn btn-success btn-sm mt-2">+ Añadir Repuesto</button>
            </div>
            
            <div class="form-group">
                <label>Tiempo de Ejecución (Horas)</label>
                <input class="form-control" type="number" step="0.5" name="tiempo_ejecucion_horas">
            </div>

            <hr>

            <h5 class="h5 mb-20 mt-3">Responsables</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Técnico Responsable</label>
                         <select class="form-control" name="tecnico_id" id="tecnico_id" required>
                            <option value="" disabled selected>Selecciona un técnico...</option>
                            @foreach ($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}">{{ $tecnico->name }}</option>
                            @endforeach
                        </select>
                    </div>
                     <div class="form-group" id="signature-section" style="display: none;">
                        <label>Firma del Técnico</label>
                        <div style="border: 1px solid #ccc; border-radius: 5px; max-width: 400px; touch-action: none;">
                            <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
                        </div>
                        <button id="clear-signature" type="button" class="btn btn-sm btn-secondary mt-2">Limpiar Firma</button>
                        <input type="hidden" name="firma_tecnico_url" id="signature-data">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Nombre de Quien Recibe</label>
                                <input class="form-control" type="text" name="recibe_nombre" required>
                            </div>
                        </div>
                        <div class="col-12">
                             <div class="form-group">
                                <label>Cargo de Quien Recibe</label>
                                <input class="form-control" type="text" name="recibe_cargo" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Crear Reporte</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sedeSelect = document.getElementById('sede_id');
    const servicioSelect = document.getElementById('servicio_id');
    const assetSelect = document.getElementById('asset_id');
    const assetSearchInput = document.getElementById('assetSearch');
    const searchResultsContainer = document.getElementById('searchResults');

    const assetNombre = document.getElementById('asset_nombre');
    const assetMarca = document.getElementById('asset_marca');
    const assetModelo = document.getElementById('asset_modelo');
    const assetSerie = document.getElementById('asset_serie');

    const tecnicoSelect = document.getElementById('tecnico_id');
    const signatureSection = document.getElementById('signature-section');
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas);

    tecnicoSelect.addEventListener('change', function() {
        if (this.value) {
            signatureSection.style.display = 'block';
        } else {
            signatureSection.style.display = 'none';
        }
    });

    document.getElementById('clear-signature').addEventListener('click', function () {
        signaturePad.clear();
    });

    document.getElementById('createReportForm').addEventListener('submit', function (event) {
        if (!signaturePad.isEmpty()) {
            document.getElementById('signature-data').value = signaturePad.toDataURL('image/png');
        }
    });
    
    // --- CÓDIGO PARA REPUESTOS ---
    const sparePartsContainer = document.getElementById('spare-parts-container');
    const addSparePartBtn = document.getElementById('add-spare-part');
    let partIndex = 0;
    
    addSparePartBtn.addEventListener('click', function() {
        const newPartRow = document.createElement('div');
        newPartRow.classList.add('row', 'mb-2', 'align-items-center', 'border', 'p-2', 'rounded');
        newPartRow.innerHTML = `
            <div class="col-md-4">
                <label class="font-weight-bold">Nombre</label>
                <input type="text" name="repuestos[${partIndex}][part_name]" class="form-control" placeholder="Nombre del repuesto" required>
            </div>
            <div class="col-md-2">
                <label class="font-weight-bold">Cantidad</label>
                <input type="number" name="repuestos[${partIndex}][quantity]" class="form-control" placeholder="Cant." min="1" value="1" required>
            </div>
            <div class="col-md-5">
                <label class="font-weight-bold">Foto (Opcional)</label>
                <input type="file" name="repuestos[${partIndex}][photo]" class="form-control-file form-control height-auto">
            </div>
            <div class="col-md-1 text-right">
                <button type="button" class="btn btn-sm btn-danger remove-part-btn mt-4">X</button>
            </div>
        `;
        sparePartsContainer.appendChild(newPartRow);
        partIndex++;
    });
    
    sparePartsContainer.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-part-btn')) {
            e.target.closest('.row').remove();
        }
    });

    // --- Lógica de carga y filtros ---
    function fetchServicios(sedeId, selectedServicioId = null) {
        if (!sedeId) {
            servicioSelect.innerHTML = '<option value="" disabled selected>Selecciona una sede primero...</option>';
            assetSelect.innerHTML = '<option value="" disabled selected>Selecciona un servicio primero...</option>';
            return;
        }

        servicioSelect.innerHTML = '<option value="" disabled selected>Cargando servicios...</option>';
        assetSelect.innerHTML = '<option value="" disabled selected>Selecciona un servicio primero...</option>';

        fetch(`{{ url('api/sedes') }}/${sedeId}/servicios`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Error de red: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                servicioSelect.innerHTML = '<option value="" disabled selected>Seleccione un servicio...</option>';
                if (data.length === 0) {
                    servicioSelect.innerHTML = '<option value="" disabled selected>No hay servicios para esta sede</option>';
                    return;
                }
                data.forEach(servicio => {
                    const option = new Option(servicio.nombre_servicio, servicio.id);
                    servicioSelect.add(option);
                });
                if (selectedServicioId) {
                    servicioSelect.value = selectedServicioId;
                    servicioSelect.dispatchEvent(new Event('change'));
                }
            })
            .catch(error => {
                console.error('Error al cargar servicios:', error);
                servicioSelect.innerHTML = '<option value="" disabled selected>Error al cargar servicios</option>';
            });
    }

    function fetchAssets(servicioId, selectedAssetId = null) {
        if (!servicioId) {
            assetSelect.innerHTML = '<option value="" disabled selected>Selecciona un servicio primero...</option>';
            return;
        }

        assetSelect.innerHTML = '<option value="" disabled selected>Cargando equipos...</option>';

        fetch(`{{ url('api/servicios') }}/${servicioId}/assets`)
            .then(response => {
                 if (!response.ok) {
                    throw new Error(`Error de red: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                assetSelect.innerHTML = '<option value="" disabled selected>Seleccione un equipo...</option>';
                 if (data.length === 0) {
                    assetSelect.innerHTML = '<option value="" disabled selected>No hay equipos para este servicio</option>';
                    return;
                }
                data.forEach(asset => {
                    const option = new Option(`${asset.nombre_equipo} (Serie: ${asset.serie || 'N/A'})`, asset.id);
                    assetSelect.add(option);
                });
                if (selectedAssetId) {
                    assetSelect.value = selectedAssetId;
                    assetSelect.dispatchEvent(new Event('change'));
                }
            })
            .catch(error => {
                console.error('Error al cargar equipos:', error);
                assetSelect.innerHTML = '<option value="" disabled selected>Error al cargar equipos</option>';
            });
    }

    function fetchAssetDetails(assetId) {
        if (!assetId) {
            assetNombre.textContent = '';
            assetMarca.textContent = '';
            assetModelo.textContent = '';
            assetSerie.textContent = '';
            return;
        };
        fetch(`{{ url('api/assets') }}/${assetId}`)
            .then(response => {
                 if (!response.ok) {
                    throw new Error(`Error de red: ${response.statusText}`);
                }
                return response.json();
            })
            .then(asset => {
                assetNombre.textContent = asset.nombre_equipo || '';
                assetMarca.textContent = asset.marca || '';
                assetModelo.textContent = asset.modelo || '';
                assetSerie.textContent = asset.serie || '';
            })
            .catch(error => {
                console.error('Error al cargar detalles del equipo:', error);
                 assetNombre.textContent = 'Error';
                 assetMarca.textContent = 'Error';
                 assetModelo.textContent = 'Error';
                 assetSerie.textContent = 'Error';
            });
    }

    function selectAndFillAsset(asset) {
        assetNombre.textContent = asset.nombre_equipo || '';
        assetMarca.textContent = asset.marca || '';
        assetModelo.textContent = asset.modelo || '';
        assetSerie.textContent = asset.serie || '';

        sedeSelect.value = asset.sede_id;
        
        fetchServicios(asset.sede_id, asset.servicio_id);
    }
    
    // --- Event Listeners ---
    sedeSelect.addEventListener('change', () => fetchServicios(sedeSelect.value));
    servicioSelect.addEventListener('change', () => fetchAssets(servicioSelect.value));
    assetSelect.addEventListener('change', () => fetchAssetDetails(assetSelect.value));
    
    assetSearchInput.addEventListener('keyup', function() {
        const query = this.value;
        if (query.length < 2) {
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
                    item.textContent = `${asset.nombre_equipo} - ${asset.serie || 'S/S'} (Sede: ${asset.sede.nombre_sede})`;
                    item.addEventListener('click', (e) => {
                        e.preventDefault();
                        selectAndFillAsset(asset);
                        searchResultsContainer.innerHTML = ''; // Hide results after selection
                        assetSearchInput.value = '';
                    });
                    searchResultsContainer.appendChild(item);
                });
            })
            .catch(error => console.error('Error en la búsqueda:', error));
    });

    // --- Carga Inicial ---
    const initialAsset = @json($selectedAsset);
    if (initialAsset) {
        selectAndFillAsset(initialAsset);
    } else if (sedeSelect.value) {
        fetchServicios(sedeSelect.value);
    }
});
</script>
@endpush

@endsection