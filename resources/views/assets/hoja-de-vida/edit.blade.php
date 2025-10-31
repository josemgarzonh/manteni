@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Editando Hoja de Vida: {{ $asset->nombre_equipo }}</h2>
    <div class="pd-20">
        <form action="{{ route('assets.hoja-de-vida.update', $asset->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h5 class="h5 mb-20">Clasificación y Tecnología</h5>
            <div class="row">
                <div class="col-md-4 form-group">
                    <label>Clasificación de Riesgo</label>
                    <select class="form-control" name="clasificacion_riesgo">
                        <option value="I" @if(optional($asset->biomedicalDetail)->clasificacion_riesgo == 'I') selected @endif>I</option>
                        <option value="IIA" @if(optional($asset->biomedicalDetail)->clasificacion_riesgo == 'IIA') selected @endif>IIA</option>
                        <option value="IIB" @if(optional($asset->biomedicalDetail)->clasificacion_riesgo == 'IIB') selected @endif>IIB</option>
                        <option value="III" @if(optional($asset->biomedicalDetail)->clasificacion_riesgo == 'III') selected @endif>III</option>
                    </select>
                </div>
                <div class="col-md-4 form-group">
                    <label>Clasificación por Uso</label>
                    <input type="text" class="form-control" name="clasificacion_uso" value="{{ optional($asset->biomedicalDetail)->clasificacion_uso }}">
                </div>
                <div class="col-md-4 form-group">
                    <label>Tecnología Predominante</label>
                     <input type="text" class="form-control" name="tecnologia_predominante" value="{{ optional($asset->biomedicalDetail)->tecnologia_predominante }}">
                </div>
            </div>

            <h5 class="h5 mb-20 mt-3">Información del Fabricante y Adquisición</h5>
            <div class="row">
                <div class="col-md-6 form-group"><label>Fabricante</label><input type="text" class="form-control" name="fabricante" value="{{ optional($asset->biomedicalDetail)->fabricante }}"></div>
                <div class="col-md-6 form-group"><label>Fecha de fabricación</label><input type="date" class="form-control" name="fecha_fabricacion" value="{{ optional($asset->biomedicalDetail)->fecha_fabricacion }}"></div>
                <div class="col-md-6 form-group"><label>Correo</label><input type="email" class="form-control" name="correo_fabricante" value="{{ optional($asset->biomedicalDetail)->correo_fabricante }}"></div>
                <div class="col-md-6 form-group"><label>Contacto</label><input type="text" class="form-control" name="contacto_fabricante" value="{{ optional($asset->biomedicalDetail)->contacto_fabricante }}"></div>
                <div class="col-md-6 form-group"><label>Forma de adquisición</label><input type="text" class="form-control" name="forma_adquisicion" value="{{ optional($asset->biomedicalDetail)->forma_adquisicion }}"></div>
                <div class="col-md-6 form-group"><label>Nombre del proveedor</label><input type="text" class="form-control" name="proveedor_nombre" value="{{ optional($asset->biomedicalDetail)->proveedor_nombre }}"></div>
                <div class="col-md-6 form-group"><label>Costo de adquisición</label><input type="number" step="0.01" class="form-control" name="costo_adquisicion" value="{{ optional($asset->biomedicalDetail)->costo_adquisicion }}"></div>
                <div class="col-md-6 form-group"><label>Vida útil</label><input type="text" class="form-control" name="vida_util" value="{{ optional($asset->biomedicalDetail)->vida_util }}"></div>
            </div>

            <h5 class="h5 mb-20 mt-3">Garantía</h5>
            <div class="row">
                <div class="col-md-6 form-group"><label>Fecha de Inicio</label><input type="date" class="form-control" name="garantia_inicio" value="{{ optional($asset->biomedicalDetail)->garantia_inicio }}"></div>
                <div class="col-md-6 form-group"><label>Fecha de Terminación</label><input type="date" class="form-control" name="garantia_fin" value="{{ optional($asset->biomedicalDetail)->garantia_fin }}"></div>
            </div>
            
            <h5 class="h5 mb-20 mt-3">Registro INVIMA</h5>
            <div class="form-group"><input type="text" class="form-control" name="registro_invima" value="{{ optional($asset->biomedicalDetail)->registro_invima }}"></div>

            <h5 class="h5 mb-20 mt-3">Registro Técnico de Funcionamiento</h5>
            <div class="row">
                <div class="col-md-3 form-group"><label>Rango de Voltaje</label><input type="text" class="form-control" name="rango_voltaje" value="{{ optional($asset->biomedicalDetail)->rango_voltaje }}"></div>
                <div class="col-md-3 form-group"><label>Rango de Corriente</label><input type="text" class="form-control" name="rango_corriente" value="{{ optional($asset->biomedicalDetail)->rango_corriente }}"></div>
                <div class="col-md-3 form-group"><label>Rango de Potencia</label><input type="text" class="form-control" name="rango_potencia" value="{{ optional($asset->biomedicalDetail)->rango_potencia }}"></div>
                <div class="col-md-3 form-group"><label>Rango de Frecuencia</label><input type="text" class="form-control" name="rango_frecuencia" value="{{ optional($asset->biomedicalDetail)->rango_frecuencia }}"></div>
                <div class="col-md-3 form-group"><label>Rango de Presión</label><input type="text" class="form-control" name="rango_presion" value="{{ optional($asset->biomedicalDetail)->rango_presion }}"></div>
                <div class="col-md-3 form-group"><label>Rango de Temperatura</label><input type="text" class="form-control" name="rango_temperatura" value="{{ optional($asset->biomedicalDetail)->rango_temperatura }}"></div>
                <div class="col-md-3 form-group"><label>Rango de Humedad</label><input type="text" class="form-control" name="rango_humedad" value="{{ optional($asset->biomedicalDetail)->rango_humedad }}"></div>
                <div class="col-md-3 form-group"><label>Peso</label><input type="text" class="form-control" name="peso" value="{{ optional($asset->biomedicalDetail)->peso }}"></div>
            </div>

            <div class="form-group">
                <label>Componentes, Accesorios y Consumibles</label>
                <textarea class="form-control" name="componentes_accesorios">{{ optional($asset->biomedicalDetail)->componentes_accesorios }}</textarea>
            </div>
             <div class="form-group">
                <label>Indicaciones dadas por el Fabricante</label>
                <textarea class="form-control" name="indicaciones_fabricante">{{ optional($asset->biomedicalDetail)->indicaciones_fabricante }}</textarea>
            </div>

            <div class="text-right">
                <a href="{{ route('assets.hoja-de-vida.show', $asset->id) }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection

