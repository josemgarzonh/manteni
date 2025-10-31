@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Hoja de Vida para: {{ $asset->nombre_equipo }}</h2>
    <div class="pd-20">
        @if (session('success'))
            <div class="alert alert-info" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('biomedical-details.store', $asset->id) }}" method="POST">
            @csrf

            <h5 class="h5 mb-20">Clasificaciones</h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Clasificación de Riesgo</label>
                        <select class="form-control" name="clasificacion_riesgo">
                            <option value="I">I</option>
                            <option value="IIA">IIA</option>
                            <option value="IIB">IIB</option>
                            <option value="III">III</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Clasificación por Uso</label>
                        <select class="form-control" name="clasificacion_uso">
                            <option value="diagnostico">Diagnóstico</option>
                            <option value="tratamiento">Tratamiento</option>
                            <option value="soporte">Soporte</option>
                            <option value="rehabilitacion">Rehabilitación</option>
                            <option value="prevencion">Prevención</option>
                            <option value="analisis de laboratorio">Análisis de Laboratorio</option>
                            <option value="esterilizacion">Esterilización</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Tecnología Predominante</label>
                        <select class="form-control" name="tecnologia_predominante">
                            <option value="electrico">Eléctrico</option>
                            <option value="electronico">Electrónico</option>
                            <option value="electromecanico">Electromecánico</option>
                            <option value="neumatico">Neumático</option>
                            <option value="hidraulico">Hidráulico</option>
                            <option value="mecanico">Mecánico</option>
                            <option value="optico">Óptico</option>
                        </select>
                    </div>
                </div>
            </div>

            <h5 class="h5 mb-20 mt-3">Información General</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fabricante</label>
                        <input class="form-control" type="text" name="fabricante">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Registro Sanitario (INVIMA)</label>
                        <input class="form-control" type="text" name="registro_invima">
                    </div>
                </div>
            </div>
             <div class="form-group">
                <label>Componentes, Accesorios y Consumibles</label>
                <textarea class="form-control" name="componentes_accesorios"></textarea>
            </div>


            <h5 class="h5 mb-20 mt-3">Registro Técnico de Funcionamiento</h5>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Rango de Voltaje</label>
                        <input class="form-control" type="text" name="rango_voltaje" placeholder="Ej: 110-220V">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Rango de Corriente</label>
                        <input class="form-control" type="text" name="rango_corriente" placeholder="Ej: 0.5-2A">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Rango de Potencia</label>
                        <input class="form-control" type="text" name="rango_potencia" placeholder="Ej: 500W">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Rango de Frecuencia</label>
                        <input class="form-control" type="text" name="rango_frecuencia" placeholder="Ej: 50-60Hz">
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label>Rango de Presión</label>
                        <input class="form-control" type="text" name="rango_presion" placeholder="Ej: 0-100 PSI">
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label>Rango de Temperatura</label>
                        <input class="form-control" type="text" name="rango_temperatura" placeholder="Ej: 10-40°C">
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label>Rango de Humedad</label>
                        <input class="form-control" type="text" name="rango_humedad" placeholder="Ej: 30-80%">
                    </div>
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                        <label>Peso</label>
                        <input class="form-control" type="text" name="peso" placeholder="Ej: 15 Kg">
                    </div>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Guardar Hoja de Vida</button>
            </div>
        </form>
    </div>
</div>
@endsection