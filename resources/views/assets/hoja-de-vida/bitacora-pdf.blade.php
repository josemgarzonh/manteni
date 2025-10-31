<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bitácora de Mantenimiento</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: Arial, sans-serif; font-size: 10px; color: #333; }
        .header { width: 100%; text-align: center; margin-bottom: 20px; }
        .header img { width: 150px; }
        .header h3 { margin: 5px 0 0 0; font-size: 14px; color: #007bff; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .table th, .table td { border: 1px solid #999; padding: 5px; text-align: left; }
        .table th { background-color: #007bff; color: #fff; font-weight: bold; text-align: center; }
        .info-table { width: 100%; margin-bottom: 10px; border-collapse: collapse; }
        .info-table td { padding: 4px 8px; border: 1px solid #ccc; }
        .info-table .label { font-weight: bold; background-color: #E6E6E6; width: 20%; }
        .section-title { background-color: #007bff; color: #fff; font-weight: bold; padding: 5px; text-align: center; font-size: 11px; margin-top: 10px; margin-bottom: 5px; }
    </style>
</head>
<body>
    <table class="header" style="border: none;">
        <tr>
            <td style="text-align: center;">
                <img src="{{ public_path('vendors/images/logo-samuel.png') }}" alt="Logo">
                <h3>BITÁCORA DE MANTENIMIENTO EQUIPOS Y MAQUINARIA</h3>
            </td>
        </tr>
    </table>

    <div class="section-title">INFORMACIÓN DEL PRESTADOR</div>
    <table class="info-table">
        <tr>
            <td class="label">NOMBRE DEL PRESTADOR:</td>
            <td>{{ $asset->sede->ips->nombre_prestador ?? 'N/A' }}</td>
            <td class="label">SEDE:</td>
            <td>{{ $asset->sede->nombre_sede ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">DIRECCIÓN:</td>
            <td>{{ $asset->sede->direccion ?? 'N/A' }}</td>
            <td class="label">CIUDAD:</td>
            <td>{{ $asset->sede->ips->municipio ?? 'EL BANCO, MAGDALENA' }}</td>
        </tr>
    </table>

    <div class="section-title">INFORMACIÓN DEL EQUIPO</div>
    <table class="info-table">
        <tr>
            <td class="label">EQUIPO:</td>
            <td>{{ $asset->nombre_equipo ?? 'N/A' }}</td>
            <td class="label">MARCA:</td>
            <td>{{ $asset->marca ?? 'N/A' }}</td>
            <td class="label">MODELO:</td>
            <td>{{ $asset->modelo ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">SERIE:</td>
            <td>{{ $asset->serie ?? 'N/A' }}</td>
            <td class="label">N° DE ACTIVO:</td>
            <td>{{ $asset->activo_fijo ?? 'N/A' }}</td>
            <td class="label">SERVICIO:</td>
            <td>{{ optional($asset->servicio)->nombre_servicio ?? 'N/A' }}</td>
        </tr>
    </table>

    <table class="table">
        <thead>
            <tr>
                <th style="width: 10%;">FECHA</th>
                <th>DESCRIPCIÓN DE LA ACTIVIDAD</th>
                <th style="width: 15%;">RESPONSABLE</th>
                <th style="width: 15%;">FECHA PRÓXIMA INTERVENCIÓN</th>
                <th style="width: 10%;">N° DE REPORTE</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($asset->maintenanceReports as $report)
            <tr>
                <td style="text-align: center;">{{ $report->created_at->format('Y-m-d') }}</td>
                <td>{{ ucfirst($report->tipo_mantenimiento) }}: {{ $report->observaciones }}</td>
                <td style="text-align: center;">{{ $report->is_manual_entry ? $report->manual_responsable : (optional($report->tecnico)->name ?? 'N/A') }}</td>
                <td style="text-align: center;">{{ $report->next_intervention_date ? \Carbon\Carbon::parse($report->next_intervention_date)->format('Y-m-d') : '' }}</td>
                <td style="text-align: center;">{{ !$report->is_manual_entry ? $report->id : 'Manual' }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align: center; padding: 20px;">No hay registros de mantenimiento para este equipo.</td></tr>
            @endforelse
            
            @if($asset->maintenanceReports->count() < 15)
                @for ($i = 0; $i < (15 - $asset->maintenanceReports->count()); $i++)
                <tr>
                    <td style="padding: 12px;">&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                @endfor
            @endif
        </tbody>
    </table>
</body>
</html>