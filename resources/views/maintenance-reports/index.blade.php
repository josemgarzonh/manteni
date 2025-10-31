@extends('layouts.app')

@section('content')
<style>
    /* Estilos para la tarjeta de reporte */
    .report-card-table {
        width: 100%;
        border-collapse: collapse;
        border: 2px solid #000; /* Borde exterior más grueso */
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
    }

    .report-card-table > tbody > tr > td {
        border: 1px solid #000; /* Bordes de celdas principales */
        padding: 0; 
        vertical-align: top;
    }

    /* Columna Izquierda (Reporte y Fecha) */
    .col-info {
        width: 18%;
        background-color: #e6f2ff;
        font-weight: bold;
        text-align: center;
        vertical-align: middle !important;
        padding: 8px;
    }
    
    /* Columna Central (Detalles del equipo) */
    .col-details {
        width: 62%;
    }

    /* Columna Derecha (Acciones) */
    .col-actions {
        width: 20%;
        background-color: #f8f9fa;
        text-align: center;
        vertical-align: middle !important;
        padding: 8px;
    }
    
    .col-actions strong {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }


    /* Estilos para la tabla interna de detalles */
    .details-table {
        width: 100%;
        height: 100%;
        border-collapse: collapse;
    }

    .details-table td {
        border: 1px solid #000;
        padding: 6px 10px;
        font-size: 13px;
        vertical-align: middle;
    }
    
    .details-table {
        border-style: hidden; /* Oculta el borde exterior de la tabla anidada */
    }

    .details-table strong {
        font-weight: bold;
        margin-right: 8px;
    }

    .btn-detalle {
        background-color: #17a2b8;
        color: white !important;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        text-decoration: none;
        display: inline-block;
        font-size: 13px;
    }

    .btn-detalle:hover {
        background-color: #138496;
    }

    /* ---- Estilos Responsivos para Móviles ---- */
    @media (max-width: 768px) {
        .report-card-table, 
        .report-card-table tbody, 
        .report-card-table tr, 
        .report-card-table td {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        .report-card-table tr {
            border: 2px solid #000;
            margin-bottom: 20px;
        }
        
        .report-card-table > tbody > tr > td {
            border: none;
            border-bottom: 1px solid #ccc;
        }
        
        .report-card-table > tbody > tr > td:last-child {
            border-bottom: none;
        }

        .col-info, .col-actions {
            width: 100%;
            text-align: left;
            padding: 10px;
        }

        .col-details {
            width: 100%;
        }

        .details-table td {
            display: block;
            width: 100%;
            border: none;
            border-bottom: 1px dotted #ccc;
            padding: 8px 10px;
        }
        
        .details-table td:last-child {
            border-bottom: none;
        }
        
        .details-table tr:last-child td:last-child {
             border-bottom: none;
        }

        .details-table strong {
            display: inline-block;
            width: 100px; /* Ancho fijo para las etiquetas en móvil */
        }

        .col-actions {
            text-align: center;
        }
    }
</style>

<div class="card-box mb-30">
    <div class="pd-20">
        <div class="clearfix">
            <div class="pull-left">
                <h2 class="h4">Historial de Reportes de Mantenimiento</h2>
            </div>
            <div class="pull-right">
                <a href="{{ route('maintenance-reports.create') }}" class="btn btn-primary">Crear Nuevo Reporte</a>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                 <div class="form-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Buscar por cualquier campo...">
                </div>
            </div>
        </div>
    </div>

    <div class="pb-20 px-3" id="reports-container">
        @forelse ($reports as $report)
        <div class="report-item">
            <table class="report-card-table">
                <tbody>
                    <tr>
                        <td class="col-info">
                           <strong>Reporte No.</strong><br>{{ $report->id }}
                           <hr style="border-top: 1px solid #000; margin: 8px 0;">
                           <strong>Fecha</strong><br>{{ $report->created_at->format('Y-m-d') }}
                        </td>
                        <td class="col-details">
                            <table class="details-table">
                                <tr>
                                    <td><strong>Equipo:</strong> {{ $report->asset->nombre_equipo ?? 'N/A' }}</td>
                                    <td><strong>Tipo de Mtto.</strong><br>{{ ucfirst($report->tipo_mantenimiento) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Marca:</strong> {{ $report->asset->marca ?? 'N/A' }}</td>
                                    <td rowspan="3" style="vertical-align: middle;"><strong>Responsable:</strong><br>{{ $report->tecnico->name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Modelo:</strong> {{ $report->asset->modelo ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Serie:</strong> {{ $report->asset->serie ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </td>
                        <td class="col-actions">
                             <strong>Acciones</strong>
                             <a href="{{ route('maintenance-reports.show', $report->id) }}" class="btn-detalle">Ver Detalle</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        @empty
        <div class="text-center pd-20">
            No hay reportes de mantenimiento registrados.
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const reportsContainer = document.getElementById('reports-container');
    const reportItems = reportsContainer.getElementsByClassName('report-item');

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();

        for (let i = 0; i < reportItems.length; i++) {
            const item = reportItems[i];
            const text = item.textContent || item.innerText;
            if (text.toLowerCase().indexOf(filter) > -1) {
                item.style.display = "";
            } else {
                item.style.display = "none";
            }
        }
    });
});
</script>
@endpush
@endsection