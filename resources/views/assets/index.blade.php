@extends('layouts.app')

@section('content')
<div class="card-box mb-30">
    <div class="pd-20 clearfix">
        <div class="pull-left">
            <h2 class="h4">Inventario de Activos</h2>
        </div>
        <div class="pull-right">
            <a href="{{ route('assets.create') }}" class="btn btn-primary">Registrar Nuevo Activo</a>
        </div>
    </div>
    <div class="pd-20">
        <div class="form-group">
            <input type="text" id="assetSearchInput" class="form-control" placeholder="Buscar en la pestaña actual...">
        </div>
    </div>


    <div class="pb-20">
        @if (session('success'))
            <div class="alert alert-success mx-4">{{ session('success') }}</div>
        @endif

        <div class="tab">
            <ul class="nav nav-tabs" role="tablist" id="assetTabs">
                @foreach ($assetTypes as $type)
                    <li class="nav-item">
                        <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-toggle="tab" href="#tab_{{ $type->id }}" role="tab" aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $type->nombre }}</a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach ($assetTypes as $type)
                    <div class="tab-pane fade show {{ $loop->first ? 'active' : '' }}" id="tab_{{ $type->id }}" role="tabpanel">
                        <div class="pd-20">
                            <table class="table table-striped asset-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>NOMBRE</th>
                                        <th>MARCA</th>
                                        <th>MODELO</th>
                                        <th>SERIE</th>
                                        <th>ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($assetsByType->get($type->id, []) as $asset)
                                    <tr class="asset-row">
                                        <td>{{ $asset->id }}</td>
                                        <td>{{ $asset->nombre_equipo }}</td>
                                        <td>{{ $asset->marca ?? 'N/A' }}</td>
                                        <td>{{ $asset->modelo ?? 'N/A' }}</td>
                                        <td>{{ $asset->serie ?? 'N/A' }}</td>
                                        <td>
                                            @if ($asset->assetType->nombre == 'Equipo Biomédico')
                                                <a href="{{ route('assets.hoja-de-vida.show', $asset->id) }}" class="btn btn-info btn-sm">Hoja de Vida</a>
                                            @endif
                                            <a href="{{ route('assets.bitacora', $asset->id) }}" class="btn btn-secondary btn-sm">Bitácora</a>
                                            <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-primary btn-sm">Editar</a>
                                            
                                            @if ($asset->specific_type == 'Desfibrilador')
                                                <a href="{{ route('defibrillator-tests.create', ['asset_id' => $asset->id]) }}" class="btn btn-success btn-sm">Test</a>
                                            @endif
                                            @if ($asset->assetType->nombre == 'Equipo Biomédico')
                                                <a href="{{ route('disposal-protocols.create', $asset->id) }}" class="btn btn-warning btn-sm">Evaluar Baja</a>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No hay activos de este tipo registrados.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('assetSearchInput');

    function filterTable() {
        const filter = searchInput.value.toLowerCase();
        const activeTabPane = document.querySelector('.tab-pane.active');
        if (!activeTabPane) return;

        const rows = activeTabPane.querySelectorAll('tbody tr.asset-row');

        rows.forEach(row => {
            const text = row.textContent || row.innerText;
            if (text.toLowerCase().indexOf(filter) > -1) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    searchInput.addEventListener('keyup', filterTable);

    // Re-apply filter when a new tab is shown
    $('#assetTabs a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        filterTable();
    });
});
</script>
@endpush
@endsection
