<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Mantenimiento No. {{ $report->id }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 10px;
            margin: 40px;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        .header-table td {
            border: 1px solid black;
            padding: 5px;
            text-align: center;
            vertical-align: middle;
        }
        .logo {
            width: 150px;
        }
        .title-cell {
            font-weight: bold;
            font-size: 12px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid black;
            margin-bottom: 15px;
        }
        .info-table th, .info-table td {
            border: 1px solid black;
            padding: 4px 6px;
            text-align: left;
        }
        .info-table th {
            font-weight: bold;
            background-color: #e6f2ff; /* Azul claro */
            font-size: 9px;
            text-align: center;
        }
        .checklist-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid black;
            margin-bottom: 15px;
        }
        .checklist-table th {
            font-weight: bold;
            background-color: #e6f2ff;
            border: 1px solid black;
            padding: 4px;
            text-align: center;
        }
        .checklist-table td {
            border: 1px solid black;
            padding: 3px;
        }
        .checklist-item {
            font-size: 8px;
        }
        .check-box {
            width: 12px;
            height: 12px;
            border: 1px solid black;
            display: inline-block;
            text-align: center;
            line-height: 12px;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
            border: 2px solid black;
        }
        .footer-table td {
            border: 1px solid black;
            padding: 5px;
            height: 60px;
        }
        .footer-table strong {
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .page-break {
            page-break-after: always;
        }
        .small-text {
            font-size: 9px;
        }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td style="width: 25%;"><img src="{{ public_path('vendors/images/logo-samuel.png') }}" alt="Logo" class="logo"></td>
            <td class="title-cell" style="width: 50%;">REPORTE DE MANTENIMIENTO EQUIPOS BIOMEDICOS</td>
            <td style="width: 25%;">
                <strong>REPORTE No:</strong> {{ $report->id }}<br><br>
                <strong>FECHA:</strong> {{ $report->created_at->format('Y-m-d') }}
            </td>
        </tr>
    </table>

    <table class="info-table">
        <thead>
            <tr><th colspan="4">INFORMACIÓN DE LA INSTITUCION</th></tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>ENTIDAD:</strong> {{ optional(optional(optional($report->asset)->sede)->ips)->nombre_prestador ?? 'N/A' }}</td>
                <td><strong>CIUDAD:</strong> El Banco, Magdalena</td>
            </tr>
            <tr>
                <td><strong>DIRECCION:</strong> {{ optional(optional($report->asset)->sede)->direccion ?? 'N/A' }}</td>
                <td><strong>TELEFONO:</strong> {{ optional(optional($report->asset)->sede)->telefono ?? 'N/A' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="info-table">
        <thead>
            <tr><th colspan="4">TIPO DE MANTENIMIENTO</th></tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>PREVENTIVO:</strong> {{ $report->tipo_mantenimiento == 'preventivo' ? 'X' : '' }}</td>
                <td><strong>CORRECTIVO:</strong> {{ $report->tipo_mantenimiento == 'correctivo' ? 'X' : '' }}</td>
                <td><strong>MEJORATIVO:</strong> {{ $report->tipo_mantenimiento == 'mejorativo' ? 'X' : '' }}</td>
                <td><strong>OTRO:</strong> {{ $report->tipo_mantenimiento == 'otro' ? 'X' : '' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="info-table">
        <thead>
            <tr><th colspan="3">INFORMACIÓN DEL EQUIPO</th></tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>EQUIPO:</strong> {{ optional($report->asset)->nombre_equipo ?? 'N/A' }}</td>
                <td><strong>MARCA:</strong> {{ optional($report->asset)->marca ?? 'N/A' }}</td>
                <td><strong>MODELO:</strong> {{ optional($report->asset)->modelo ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>SERIE:</strong> {{ optional($report->asset)->serie ?? 'N/A' }}</td>
                <td><strong>N° DE ACTIVO:</strong> {{ optional($report->asset)->activo_fijo ?? 'N/A' }}</td>
                <td><strong>SERVICIO:</strong> {{ optional(optional($report->asset)->servicio)->nombre_servicio ?? 'N/A' }}</td>
            </tr>
        </tbody>
    </table>

    <table class="checklist-table">
        <thead>
            <tr><th colspan="9">DESCRIPCIÓN DEL SERVICIO</th></tr>
            <tr>
                <th colspan="2">ITEM</th>
                <th>SI/NO</th>
                <th colspan="2">ITEM</th>
                <th>SI/NO</th>
                <th colspan="2">ITEM</th>
                <th>SI/NO</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < 31; $i++)
                <tr>
                    {{-- Columna 1 --}}
                    @if(isset($checklistColumns[0][$i]))
                        <td class="checklist-item" colspan="2">{{ $checklistColumns[0][$i] }}</td>
                        <td class="text-center">{{ strtoupper($report->checklistItems->firstWhere('item_nombre', $checklistColumns[0][$i])->estado ?? 'NA') }}</td>
                    @else
                        <td colspan="3"></td>
                    @endif
                    
                    {{-- Columna 2 --}}
                    @if(isset($checklistColumns[1][$i]))
                        <td class="checklist-item" colspan="2">{{ $checklistColumns[1][$i] }}</td>
                        <td class="text-center">{{ strtoupper($report->checklistItems->firstWhere('item_nombre', $checklistColumns[1][$i])->estado ?? 'NA') }}</td>
                    @else
                        <td colspan="3"></td>
                    @endif

                    {{-- Columna 3 --}}
                    @if(isset($checklistColumns[2][$i]))
                        <td class="checklist-item" colspan="2">{{ $checklistColumns[2][$i] }}</td>
                        <td class="text-center">{{ strtoupper($report->checklistItems->firstWhere('item_nombre', $checklistColumns[2][$i])->estado ?? 'NA') }}</td>
                    @else
                        <td colspan="3"></td>
                    @endif
                </tr>
            @endfor
        </tbody>
    </table>

    <table class="info-table">
        <thead><tr><th>OBSERVACIONES</th></tr></thead>
        <tbody><tr><td style="height: 50px;">{{ $report->observaciones ?? 'N/A' }}</td></tr></tbody>
    </table>

    <table class="info-table">
        <thead><tr><th>REPUESTOS UTILIZADOS</th></tr></thead>
        <tbody><tr><td style="height: 50px;">{{ $report->repuestos_utilizados ?? 'N/A' }}</td></tr></tbody>
    </table>

    <table class="footer-table">
         <thead><tr><th colspan="2">RESPONSABLE</th></tr></thead>
        <tbody>
            <tr>
                <td style="width: 50%;">
                    <strong>ENTREGA:</strong> {{ optional($report->tecnico)->name ?? 'N/A' }}<br><br>
                    <strong>CARGO:</strong> {{ optional($report->tecnico)->cargo ?? 'Ingeniero Biomédico' }}<br><br>
                    <strong>FIRMA:</strong>
                </td>
                <td style="width: 50%;">
                    <strong>RECIBE:</strong> {{ $report->recibe_nombre ?? 'N/A' }}<br><br>
                    <strong>CARGO:</strong> {{ $report->recibe_cargo ?? 'N/A' }}<br><br>
                    <strong>FIRMA:</strong>
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>