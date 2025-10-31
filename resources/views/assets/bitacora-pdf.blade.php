<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Bitácora de Mantenimiento</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .header, .footer { width: 100%; text-align: center; position: fixed; }
        .header { top: 0px; }
        .footer { bottom: 0px; }
        .content { margin-top: 150px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 6px; }
        .table th { background-color: #f2f2f2; text-align: left; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 4px; }
        h4 { margin-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h3>BITÁCORA DE MANTENIMIENTO EQUIPOS Y MAQUINARIA</h3>
    </div>

    <div class="content">
        <h4>INFORMACIÓN DEL PRESTADOR</h4>
        <table class="info-table">
            <tr>
                <td><strong>NOMBRE DEL PRESTADOR:</strong> {{ $asset->sede->ips->nombre_prestador ?? 'N/A' }}</td>
                <td><strong>SEDE:</strong> {{ $asset->sede->nombre_sede ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td><strong>DIRECCIÓN:</strong> {{ $asset->sede->direccion ?? 'N/A' }}</td>
                <td><strong>CIUDAD:</strong> {{ $asset->sede->ips->municipio ?? 'N/A' }}</td>
            </tr>
        </table>

        <h4>INFORMACIÓN DEL EQUIPO</h4>
        <table class="info-table">
            <tr>
                <td><strong>EQUIPO:</strong> {{ $asset->nombre_equipo }}</td>
                <td><strong>MARCA:</strong> {{ $asset->marca }}</td>
                <td><strong>MODELO:</strong> {{ $asset->modelo }}</td>
            </tr>
            <tr>
                <td><strong>SERIE:</strong> {{ $asset->serie }}</td>
                <td><strong>N° DE ACTIVO:</strong> {{ $asset->activo_fijo }}</td>
                <td><strong>SERVICIO:</strong> {{ $asset->servicio->nombre_servicio ?? 'N/A' }}</td>
            </tr>
        </table>

        <table class="table">
            <thead>
                <tr>
                    <th>FECHA</th>
                    <th>DESCRIPCIÓN DE LA ACTIVIDAD</th>
                    <th>RESPONSABLE</th>
                    <th>FECHA PRÓXIMA INTERVENCIÓN</th>
                    <th>N° DE REPORTE</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($asset->maintenanceReports as $report)
                <tr>
                    <td>{{ $report->created_at->format('Y-m-d') }}</td>
                    <td>{{ ucfirst($report->tipo_mantenimiento) }}</td>
                    <td>{{ $report->is_manual_entry ? $report->manual_responsable : ($report->tecnico->name ?? 'N/A') }}</td>
                    <td>{{ $report->next_intervention_date ? \Carbon\Carbon::parse($report->next_intervention_date)->format('Y-m-d') : '' }}</td>
                    <td>{{ !$report->is_manual_entry ? $report->id : 'Manual' }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align: center;">No hay registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>