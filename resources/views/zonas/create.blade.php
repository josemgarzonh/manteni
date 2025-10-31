@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Añadir Nueva Zona</h2>
    <div class="pd-20">
        <form action="{{ route('zonas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Sede a la que Pertenece</label>
                <select class="form-control" name="sede_id" id="sede_id" required>
                    <option value="" disabled selected>Seleccione una sede...</option>
                    @foreach($sedes as $sede)
                        <option value="{{ $sede->id }}">{{ $sede->nombre_sede }}</option>
                    @endforeach
                </select>
            </div>
             <div class="form-group">
                <label>Servicio al que Pertenece (Opcional)</label>
                <select class="form-control" name="servicio_id" id="servicio_id">
                    <option value="">Seleccione una sede primero...</option>
                </select>
            </div>
            <div class="form-group"><label>Nombre de la Zona</label><input class="form-control" type="text" name="nombre_zona" required></div>
            <div class="text-right">
                <a href="{{ route('zonas.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Zona</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const sedeSelect = document.getElementById('sede_id');
    const servicioSelect = document.getElementById('servicio_id');

    sedeSelect.addEventListener('change', function() {
        const sedeId = this.value;
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
                    servicioSelect.add(option);
                });
            })
            .catch(error => {
                console.error('Error al cargar los servicios:', error);
                servicioSelect.innerHTML = '<option value="">Error al cargar servicios</option>';
            });
    });
});
</script>
@endpush
@endsection
