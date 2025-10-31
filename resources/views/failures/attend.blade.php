@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-7 col-md-12 mb-30">
        <div class="card-box pd-20">
            <h4 class="h4 text-blue">Atención de Falla #{{ $maintenanceRequest->id }}</h4>
            <p><strong>Reportado el:</strong> {{ $maintenanceRequest->created_at->format('d/m/Y H:i A') }}</p>
            
            <h5 class="h5 mt-4">Detalles del Reporte</h5>
            <table class="table table-bordered table-sm">
                <tr><th>Reportado por</th><td>{{ $maintenanceRequest->user->name ?? $maintenanceRequest->solicitante_nombre }}</td></tr>
                <tr><th>Equipo</th><td>{{ $maintenanceRequest->asset->nombre_equipo ?? 'No especificado' }}</td></tr>
                <tr><th>Ubicación</th><td>{{ $maintenanceRequest->ubicacion_texto }}</td></tr>
                <tr><th>Descripción</th><td>{{ $maintenanceRequest->descripcion }}</td></tr>
            </table>

            @if($maintenanceRequest->imagen_url)
                <h5 class="h5 mt-4">Imagen del Reporte</h5>
                <img src="{{ asset('storage/' . $maintenanceRequest->imagen_url) }}" class="img-fluid rounded" alt="Imagen de la falla">
            @endif

            <hr>

            <h5 class="h5 mt-4">Historial de Atenciones</h5>
            @forelse($maintenanceRequest->attentions->sortByDesc('created_at') as $attention)
                <div class="bs-callout bs-callout-info">
                    <p class="mb-1"><strong>Fecha:</strong> {{ $attention->created_at->format('d/m/Y H:i A') }} por <strong>{{ $attention->technician->name }}</strong></p>
                    <p class="mb-1"><strong>Estado:</strong> <span class="badge badge-info">{{ ucfirst($attention->estado_falla) }}</span></p>
                    <p class="mb-1"><strong>Detalles:</strong> {{ $attention->detalles_tecnicos }}</p>
                    @if($attention->images->isNotEmpty())
                        <p class="mb-1"><strong>Imágenes adjuntas:</strong>
                        @foreach($attention->images as $image)
                            <a href="{{ asset('storage/' . $image->image_url) }}" target="_blank" class="mr-2">Ver Imagen {{ $loop->iteration }}</a>
                        @endforeach
                        </p>
                    @endif
                </div>
            @empty
                <p>Aún no hay atenciones registradas para esta falla.</p>
            @endforelse
        </div>
    </div>

    <div class="col-lg-5 col-md-12 mb-30">
        <div class="card-box pd-20">
            <h5 class="h5 mb-4">Registrar Nueva Atención</h5>
            <form action="{{ route('failures.storeAttention', $maintenanceRequest->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label><strong>Detalles Técnicos de la Intervención</strong></label>
                    <textarea name="detalles_tecnicos" class="form-control" rows="4" required></textarea>
                </div>

                <div class="form-group">
                    <label><strong>Actualizar Estado de la Falla</strong></label>
                    <select name="estado_falla" class="form-control" required>
                        <option value="activa" {{ $maintenanceRequest->estado_falla == 'activa' ? 'selected' : '' }}>Activa</option>
                        <option value="en espera" {{ $maintenanceRequest->estado_falla == 'en espera' ? 'selected' : '' }}>En Espera (Repuesto, etc.)</option>
                        <option value="postergada" {{ $maintenanceRequest->estado_falla == 'postergada' ? 'selected' : '' }}>Postergada</option>
                        <option value="despejada" {{ $maintenanceRequest->estado_falla == 'despejada' ? 'selected' : '' }}>Despejada (Solucionada)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Adjuntar Imágenes (de la reparación, opcional)</label>
                    <input type="file" name="imagenes[]" class="form-control-file" multiple>
                </div>
                
                <hr>

                <div class="form-group">
                    <h5 class="h5 mb-2">Solicitar Repuestos (si es necesario)</h5>
                    <div id="spare-parts-container">
                        </div>
                    <button type="button" id="add-spare-part" class="btn btn-success btn-sm mt-2">+ Añadir Repuesto</button>
                </div>

                <hr>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Guardar Atención</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sparePartsContainer = document.getElementById('spare-parts-container');
    const addSparePartBtn = document.getElementById('add-spare-part');
    let partIndex = 0;
    
    addSparePartBtn.addEventListener('click', function() {
        const newPartRow = document.createElement('div');
        newPartRow.classList.add('row', 'mb-2', 'align-items-center', 'border', 'p-2', 'rounded');
        newPartRow.innerHTML = `
            <div class="col-md-5">
                <input type="text" name="repuestos[${partIndex}][part_name]" class="form-control form-control-sm" placeholder="Nombre repuesto" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="repuestos[${partIndex}][quantity]" class="form-control form-control-sm" placeholder="Cant." min="1" value="1" required>
            </div>
            <div class="col-md-4">
                <input type="file" name="repuestos[${partIndex}][photo]" class="form-control-file form-control-sm">
            </div>
            <div class="col-md-1 text-right">
                <button type="button" class="btn btn-sm btn-danger remove-part-btn">&times;</button>
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
});
</script>
@endpush
@endsection