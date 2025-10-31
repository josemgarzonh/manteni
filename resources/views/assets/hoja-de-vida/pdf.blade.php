<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hoja de Vida - {{ $asset->nombre_equipo }}</title>
    <style>
        @page { margin: 0.5cm 1.5cm; }
        body { font-family: Arial, sans-serif; font-size: 9px; color: #333; }
        .header-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .header-table td { vertical-align: middle; text-align: center; }
        .logo { width: 120px; }
        .title { font-size: 14px; font-weight: bold; color: #007bff; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        .table th, .table td { border: 1px solid #999; padding: 4px; vertical-align: top; text-align: left; }
        .table th { background-color: #E6E6E6; font-weight: bold; }
        .section-title td { background-color: #007bff; color: #fff; text-align: center; font-weight: bold; padding: 5px; font-size: 10px; }
        .image-box { width: 180px; height: 150px; border: 1px solid #999; text-align: center; vertical-align: middle; }
        .footer { position: fixed; bottom: -25px; left: 0px; right: 0px; width: 100%; text-align: center; font-size: 8px; color: #888; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 25%; text-align: left;"><img src="{{ public_path('vendors/images/logo-samuel.png') }}" alt="Logo" class="logo"></td>
            <td style="width: 50%;"><div class="title">HOJA DE VIDA DE EQUIPOS BIOMÉDICOS</div></td>
            <td style="width: 25%;"></td>
        </tr>
    </table>

    <table style="width: 100%; border-spacing: 0; border-collapse: collapse;">
        <tr>
            <td style="width: calc(100% - 190px); vertical-align: top; padding: 0;">
                <table class="table">
                    <tr><th style="width: 35%;">Nombre del equipo</th><td>{{ $asset->nombre_equipo ?? 'N/A' }}</td></tr>
                    <tr><th>Activo fijo</th><td>{{ $asset->activo_fijo ?? 'N/A' }}</td></tr>
                    <tr><th>Marca</th><td>{{ $asset->marca ?? 'N/A' }}</td></tr>
                    <tr><th>Modelo</th><td>{{ $asset->modelo ?? 'N/A' }}</td></tr>
                    <tr><th>Serie</th><td>{{ $asset->serie ?? 'N/A' }}</td></tr>
                    <tr><th>Clasificación del riesgo</th><td>{{ optional($asset->biomedicalDetail)->clasificacion_riesgo ?? 'N/A' }}</td></tr>
                    <tr><th>Registro INVIMA</th><td>{{ optional($asset->biomedicalDetail)->registro_invima ?? 'N/A' }}</td></tr>
                    <tr><th>Servicio</th><td>{{ optional($asset->servicio)->nombre_servicio ?? 'N/A' }}</td></tr>
                    <tr><th>Ubicación</th><td>{{ optional($asset->zona)->nombre_zona ?? 'N/A' }}</td></tr>
                </table>
            </td>
            <td style="width: 190px; vertical-align: top; padding: 0 0 0 10px;">
                <div class="image-box">
                    @if($asset->imagen_url && file_exists(public_path('storage/' . $asset->imagen_url)))
                        <img src="{{ public_path('storage/' . $asset->imagen_url) }}" alt="Imagen Equipo" style="max-width: 100%; max-height: 100%;">
                    @else
                        <p style="padding-top: 60px;">IMAGEN EQUIPO BIOMEDICO</p>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <table class="table">
        <tr class="section-title"><td colspan="2">CLASIFICACIÓN Y TECNOLOGÍA</td></tr>
        <tr>
            <th style="width: 50%;">Clasificación de acuerdo con el uso</th>
            <td>{{ optional($asset->biomedicalDetail)->clasificacion_uso ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Tipo de tecnología predominante</th>
            <td>{{ optional($asset->biomedicalDetail)->tecnologia_predominante ?? 'N/A' }}</td>
        </tr>
    </table>

    <table class="table">
        <tr class="section-title"><td colspan="2">INFORMACIÓN DEL FABRICANTE Y ADQUISICIÓN</td></tr>
        <tr><th style="width: 50%;">Fabricante</th><td>{{ optional($asset->biomedicalDetail)->fabricante ?? 'N/A' }}</td></tr>
        <tr><th>Fecha de adquisición</th><td>{{ $asset->fecha_adquisicion ?? 'N/A' }}</td></tr>
    </table>

    <table class="table">
        <tr class="section-title"><td colspan="4">REGISTRO TÉCNICO DE FUNCIONAMIENTO</td></tr>
        <tr>
            <th style="width: 25%;">RANGO DE VOLTAJE</th><td style="width: 25%;">{{ optional($asset->biomedicalDetail)->rango_voltaje ?? 'N/A' }}</td>
            <th style="width: 25%;">RANGO DE PRESIÓN</th><td style="width: 25%;">{{ optional($asset->biomedicalDetail)->rango_presion ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>RANGO DE CORRIENTE</th><td>{{ optional($asset->biomedicalDetail)->rango_corriente ?? 'N/A' }}</td>
            <th>RANGO DE TEMPERATURA</th><td>{{ optional($asset->biomedicalDetail)->rango_temperatura ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>RANGO DE POTENCIA</th><td>{{ optional($asset->biomedicalDetail)->rango_potencia ?? 'N/A' }}</td>
            <th>RANGO DE HUMEDAD</th><td>{{ optional($asset->biomedicalDetail)->rango_humedad ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>RANGO DE FRECUENCIA</th><td>{{ optional($asset->biomedicalDetail)->rango_frecuencia ?? 'N/A' }}</td>
            <th>PESO</th><td>{{ optional($asset->biomedicalDetail)->peso ?? 'N/A' }}</td>
        </tr>
    </table>

    <table class="table">
         <tr class="section-title"><td>COMPONENTES, ACCESORIOS Y CONSUMIBLES</td></tr>
         <tr><td style="height: 50px;">{{ optional($asset->biomedicalDetail)->componentes_accesorios ?? 'N/A' }}</td></tr>
    </table>

    <table class="table">
         <tr class="section-title"><td>INDICACIONES DADAS POR EL FABRICANTE</td></tr>
         <tr><td style="height: 50px;"></td></tr>
    </table>

    <div class="footer">
        Sede administrativa: CALLE 7 CARRERA 7 ESQUINA - TEL. (605) 4292551-Administrativa-<br>
        Sede Asistencial CALLE NUEVA: CALLE 7 CARRERA 7 ESQUINA TELEFONOS (605) 4124306-(605) 4294157-Consulta externa-<br>
        Sede Asistencial TOMAS TORRES LENGUA: CALLE 14 CARRERA 6 ESQUINA - TELEFAX: (605) 4293791-Urgencias-<br>
        E-MAIL: contactenos@esesamuelvillanueva.gov.co<br>
        EL BANCO MAGDALENA
    </div>
</body>
</html>
