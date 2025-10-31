@extends('layouts.app')

@section('content')
<div class="card-box mb-30 pd-20">
    <div class="clearfix">
        <div class="pull-left">
            <h4 class="text-blue h4">Hoja de Vida: {{ $asset->nombre_equipo }}</h4>
        </div>
        <div class="pull-right">
            <a href="{{ route('assets.hoja-de-vida.edit', $asset->id) }}" class="btn btn-primary">Editar Hoja de Vida</a>
            <a href="{{ route('assets.hoja-de-vida.pdf', $asset->id) }}" class="btn btn-secondary" target="_blank">Descargar PDF</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            @if($asset->imagen_url)
                <img src="{{ asset('storage/' . $asset->imagen_url) }}" alt="Imagen del Equipo" class="img-fluid rounded">
            @else
                <div class="border rounded text-center p-5 bg-light">
                    <p>IMAGEN EQUIPO BIOMEDICO</p>
                </div>
            @endif
        </div>
        <div class="col-md-8">
            <table class="table table-sm table-bordered">
                <tr><th>Nombre del equipo</th><td>{{ $asset->nombre_equipo }}</td></tr>
                <tr><th>Activo fijo</th><td>{{ $asset->activo_fijo }}</td></tr>
                <tr><th>Marca</th><td>{{ $asset->marca }}</td></tr>
                <tr><th>Modelo</th><td>{{ $asset->modelo }}</td></tr>
                <tr><th>Serie</th><td>{{ $asset->serie }}</td></tr>
                <tr><th>Clasificación del riesgo</th><td>{{ optional($asset->biomedicalDetail)->clasificacion_riesgo }}</td></tr>
                <tr><th>Registro INVIMA</th><td>{{ optional($asset->biomedicalDetail)->registro_invima }}</td></tr>
                <tr><th>Servicio</th><td>{{ optional($asset->servicio)->nombre_servicio }}</td></tr>
                <tr><th>Ubicación</th><td>{{ optional($asset->zona)->nombre_zona }}</td></tr>
            </table>
        </div>
    </div>

    <h5 class="h5 mb-20 mt-30">Clasificación y Tecnología</h5>
    <table class="table table-bordered">
        <tr>
            <th style="width: 50%;">Clasificación de acuerdo con el uso</th>
            <td>{{ optional($asset->biomedicalDetail)->clasificacion_uso }}</td>
        </tr>
        <tr>
            <th>Tipo de tecnología predominante</th>
            <td>{{ optional($asset->biomedicalDetail)->tecnologia_predominante }}</td>
        </tr>
    </table>

    <h5 class="h5 mb-20 mt-30">Información del Fabricante y Adquisición</h5>
    <table class="table table-bordered">
        <tr><th style="width: 25%;">Fabricante</th><td>{{ optional($asset->biomedicalDetail)->fabricante }}</td><th style="width: 25%;">Fecha de fabricación</th><td>{{ optional($asset->biomedicalDetail)->fecha_fabricacion }}</td></tr>
        <tr><th>Correo</th><td>{{ optional($asset->biomedicalDetail)->correo_fabricante }}</td><th>Contacto</th><td>{{ optional($asset->biomedicalDetail)->contacto_fabricante }}</td></tr>
        <tr><th>Fecha de adquisición</th><td>{{ $asset->fecha_adquisicion }}</td><th>Forma de adquisición</th><td>{{ optional($asset->biomedicalDetail)->forma_adquisicion }}</td></tr>
        <tr><th>Nombre del proveedor</th><td>{{ optional($asset->biomedicalDetail)->proveedor_nombre }}</td><th>Costo de adquisición</th><td>${{ number_format(optional($asset->biomedicalDetail)->costo_adquisicion, 2) }}</td></tr>
        <tr><th>Vida útil</th><td colspan="3">{{ optional($asset->biomedicalDetail)->vida_util }}</td></tr>
        <tr><th>Garantía</th><td colspan="3">Desde {{ optional($asset->biomedicalDetail)->garantia_inicio }} hasta {{ optional($asset->biomedicalDetail)->garantia_fin }}</td></tr>
    </table>

    <h5 class="h5 mb-20 mt-30">Registro Técnico de Funcionamiento</h5>
    <table class="table table-bordered">
        <tr>
            <th style="width: 25%;">RANGO DE VOLTAJE</th><td>{{ optional($asset->biomedicalDetail)->rango_voltaje }}</td>
            <th style="width: 25%;">RANGO DE PRESIÓN</th><td>{{ optional($asset->biomedicalDetail)->rango_presion }}</td>
        </tr>
        <tr>
            <th>RANGO DE CORRIENTE</th><td>{{ optional($asset->biomedicalDetail)->rango_corriente }}</td>
            <th>RANGO DE TEMPERATURA</th><td>{{ optional($asset->biomedicalDetail)->rango_temperatura }}</td>
        </tr>
        <tr>
            <th>RANGO DE POTENCIA</th><td>{{ optional($asset->biomedicalDetail)->rango_potencia }}</td>
            <th>RANGO DE HUMEDAD</th><td>{{ optional($asset->biomedicalDetail)->rango_humedad }}</td>
        </tr>
        <tr>
            <th>RANGO DE FRECUENCIA</th><td>{{ optional($asset->biomedicalDetail)->rango_frecuencia }}</td>
            <th>PESO</th><td>{{ optional($asset->biomedicalDetail)->peso }}</td>
        </tr>
    </table>

    <h5 class="h5 mb-20 mt-30">Componentes, Accesorios y Consumibles</h5>
    <div class="p-3 border rounded">
        <p>{{ optional($asset->biomedicalDetail)->componentes_accesorios }}</p>
    </div>

    <h5 class="h5 mb-20 mt-30">Indicaciones dadas por el Fabricante</h5>
    <div class="p-3 border rounded">
        <p>{{ optional($asset->biomedicalDetail)->indicaciones_fabricante }}</p>
    </div>
</div>
@endsection

