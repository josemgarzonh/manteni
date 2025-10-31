@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Editar Zona</h2>
    <div class="pd-20">
        <form action="{{ route('zonas.update', $zona->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Sede a la que Pertenece</label>
                <select class="form-control" name="sede_id" id="sede_id" required>
                    @foreach($sedes as $sede)
                        <option value="{{ $sede->id }}" {{ $zona->sede_id == $sede->id ? 'selected' : '' }}>{{ $sede->nombre_sede }}</option>
                    @endforeach
                </select>
            </div>
             <div class="form-group">
                <label>Servicio al que Pertenece (Opcional)</label>
                <select class="form-control" name="servicio_id" id="servicio_id">
                    <option value="">Cargando...</option>
                </select>
            </div>
            <div class="form-group"><label>Nombre de la Zona</label><input class="form-control" type="text" name="nombre_zona" value="{{ $zona->nombre_zona }}" required></div>
            <div class="text-right">
                <a href="{{ route('zonas.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Zona</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sedeSelect = document.getElementById('sede_id');
    const servicioSelect = document.getElementById('servicio_id');
    const currentServicioId = {{ $zona->servicio_id ?? 'null' }};

    function fetchAndPopulateServicios(sedeId, selectedServicioId = null) {
        servicioSelect.innerHTML = '<option value="">Cargando servicios...</option>';

        if (!sedeId) {
            servicioSelect.innerHTML = '<option value="">Seleccione una sede primero...</option>';
            return;
        }

        fetch(`{{ url('api/sedes') }}/${sedeId}/servicios`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(servicios => {
                servicioSelect.innerHTML = '<option value="">Ninguno</option>';
                servicios.forEach(servicio => {
                    const option = new Option(servicio.nombre_servicio, servicio.id);
                    if (servicio.id == selectedServicioId) {
                        option.selected = true;
                    }
                    servicioSelect.add(option);
                });
            })
            .catch(error => {
                console.error('Error al cargar los servicios:', error);
                servicioSelect.innerHTML = '<option value="">Error al cargar servicios</option>';
            });
    }

    // Cargar los servicios para la sede seleccionada al cargar la página.
    if (sedeSelect.value) {
        fetchAndPopulateServicios(sedeSelect.value, currentServicioId);
    }

    // Añadir el listener para cuando el usuario cambie de sede.
    sedeSelect.addEventListener('change', function() {
        fetchAndPopulateServicios(this.value);
    });
});
</script>
@endpush
@endsection
