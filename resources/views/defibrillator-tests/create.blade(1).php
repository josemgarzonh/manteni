@extends('layouts.app')
@section('content')
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Nuevo Test de Desfibriladores</h2>
    <div class="pd-20">
        {{-- Es importante añadir enctype para la subida de archivos --}}
        <form id="testForm" action="{{ route('defibrillator-tests.store') }}" method="POST" enctype="multipart/form-data">
            
                        @extends('layouts.app')
                        @section('content')
                        <div class="card-box mb-30">
                            <h2 class="h4 pd-20">Nuevo Test de Desfibriladores</h2>
                            <div class="pd-20">
                                {{-- Es importante añadir enctype para la subida de archivos --}}
                                <form id="testForm" action="{{ route('defibrillator-tests.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                        
                                    {{-- AÑADIR ESTE BLOQUE PARA MOSTRAR ERRORES --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                    {{-- FIN DEL BLOQUE DE ERRORES --}}
                        
                                    <div class="row">
                     {{-- ... El resto de tu formulario sigue aquí ... --}}
            
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Desfibrilador</label>
                        <select name="asset_id" class="form-control" required>
                            @foreach($defibrillators as $defib)
                            <option value="{{ $defib->id }}">{{ $defib->nombre_equipo }} (Serie: {{ $defib->serie }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                     <div class="form-group">
                        <label>Servicio donde se realiza el Test</label>
                        <select name="servicio_id" class="form-control" required>
                           @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}">{{ $servicio->nombre_servicio }}</option>
                           @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <hr>
            <h5 class="h5 mb-20">Criterios de Revisión</h5>
            
            @php
                $criterios = [
                    'criterio_1_estado_externo' => '1. Verificar el estado externo del equipo, que la carcasa este limpia y en buenas condiciones.',
                    'criterio_2_limpieza_palas' => '2. Inspeccionar la limpieza y buen estado de las palas, parches, cables de electrodos de ECG.',
                    'criterio_3_nivel_bateria' => '3. Revisar el nivel de la bateria (el equipo debe estar conectado permanentemente).',
                    'criterio_4_papel_registrador' => '4. Asegurarse que haya papel en el registrador.',
                    'criterio_5_test_descarga' => '5. Realizar el test de descarga.'
                ];
            @endphp

            @foreach($criterios as $key => $value)
            <div class="form-group">
                <label>{{ $value }}</label>
                <div>
                    <input type="radio" name="{{ $key }}" value="1" required> Cumple
                    <input type="radio" name="{{ $key }}" value="0"> No Cumple
                </div>
            </div>
            @endforeach

            <hr>

            <div class="form-group">
                <label>Nombre del Responsable del Servicio (Jefe de Servicio)</label>
                <input type="text" name="responsable_servicio_nombre" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Firma del Responsable del Servicio</label>
                <div style="border: 1px solid #ccc; border-radius: 5px; max-width: 400px;">
                    <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
                </div>
                <button id="clear" type="button" class="btn btn-sm btn-secondary mt-2">Limpiar Firma</button>
                <input type="hidden" name="signature" id="signature-data">
            </div>

            <div class="form-group">
                <label>Adjuntar Fotografías (Opcional)</label>
                <input type="file" name="photos[]" class="form-control-file form-control height-auto" multiple>
            </div>

             <div class="form-group">
                <label>Observaciones</label>
                <textarea name="observaciones" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Test</button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var canvas = document.getElementById('signature-pad');
        var signaturePad = new SignaturePad(canvas);

        document.getElementById('clear').addEventListener('click', function () {
            signaturePad.clear();
        });

        document.getElementById('testForm').addEventListener('submit', function (event) {
            if (!signaturePad.isEmpty()) {
                document.getElementById('signature-data').value = signaturePad.toDataURL('image/png');
            }
        });
    });
</script>
@endsection