<?php

namespace App\Http\Controllers;

use App\Models\AssetType;
use App\Models\Sede;
use App\Models\Zona;
use App\Models\Servicio;
use App\Models\Asset;
use App\Models\BiomedicalDetail;
use Illuminate\Http\Request;
use App\Models\MaintenanceReport;
use Illuminate\Support\Facades\Auth;
use PDF;

class AssetController extends Controller
{
    /**
     * Muestra una lista de todos los activos, agrupados por tipo en pestañas.
     */
    public function index()
    {
        // Obtenemos todos los tipos de activos para crear las pestañas
        $assetTypes = AssetType::with('assets')->get();
        
        // Obtenemos todos los activos y los agrupamos por su tipo
        $assetsByType = Asset::with(['assetType', 'sede', 'zona'])->get()->groupBy('asset_type_id');

        return view('assets.index', [
            'assetTypes' => $assetTypes,
            'assetsByType' => $assetsByType
        ]);
    }

    public function create()
    {
        $assetTypes = AssetType::all();
        $sedes = Sede::all();
        $zonas = Zona::all();
        $servicios = Servicio::all();
        return view('assets.create', [
            'assetTypes' => $assetTypes,
            'sedes' => $sedes,
            'zonas' => $zonas,
            'servicios' => $servicios,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_equipo' => 'required|string|max:255',
            'asset_type_id' => 'required|exists:asset_types,id',
            'sede_id' => 'required|exists:sedes,id',
            'zona_id' => 'required|exists:zonas,id',
            'specific_type' => 'nullable|string|max:255',
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'serie' => 'nullable|string|max:255',
        ]);

        $asset = Asset::create($validated);
        
        $biomedical_type = AssetType::where('nombre', 'Equipo Biomédico')->first();
        
        if ($asset->asset_type_id == $biomedical_type->id) {
            return redirect()->route('biomedical-details.create', ['asset' => $asset->id])
                             ->with('success', 'Activo base creado. Por favor, completa la Hoja de Vida.');
        }
        
        return redirect()->route('assets.index')->with('success', 'Activo registrado exitosamente.');
    }
    
    public function edit(Asset $asset)
    {
        $assetTypes = AssetType::all();
        $sedes = Sede::all();
        $zonas = Zona::all();
        $servicios = Servicio::all();
        return view('assets.edit', compact('asset', 'assetTypes', 'sedes', 'zonas', 'servicios'));
    }
    
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'nombre_equipo' => 'required|string|max:255',
            'asset_type_id' => 'required|exists:asset_types,id',
            'sede_id' => 'required|exists:sedes,id',
            'specific_type' => 'nullable|string|max:255',
            // ... y otras validaciones
        ]);
        $asset->update($validated);
        return redirect()->route('assets.index')->with('success', 'Activo actualizado exitosamente.');
    }
    
    // --- MÉTODOS DE LA HOJA DE VIDA ---
    public function showHojaDeVida(Asset $asset)
    {
        $asset->load('biomedicalDetail', 'sede.ips', 'servicio', 'zona');
        return view('assets.hoja-de-vida.show', ['asset' => $asset]);
    }

    public function editHojaDeVida(Asset $asset)
    {
        $asset->load('biomedicalDetail');
        return view('assets.hoja-de-vida.edit', ['asset' => $asset]);
    }

    public function updateHojaDeVida(Request $request, Asset $asset)
    {
        $validatedAsset = $request->validate([
            'nombre_equipo' => 'required|string|max:255',
            'marca' => 'nullable|string',
            'modelo' => 'nullable|string',
            'serie' => 'nullable|string',
        ]);
        $asset->update($validatedAsset);

        $validatedDetails = $request->validate([
            'clasificacion_riesgo' => 'required|string',
            // ... aquí irían las validaciones para todos los otros campos
        ]);
        
        $asset->biomedicalDetail()->updateOrCreate(['asset_id' => $asset->id], $validatedDetails);

        return redirect()->route('assets.hoja-de-vida.show', $asset->id)->with('success', 'Hoja de Vida actualizada exitosamente.');
    }
    
    public function downloadHojaDeVidaPDF(Asset $asset)
    {
        $asset->load('biomedicalDetail', 'sede.ips', 'servicio', 'zona');
        $pdf = PDF::loadView('assets.hoja-de-vida.pdf', ['asset' => $asset]);
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('hoja-de-vida-' . $asset->nombre_equipo . '.pdf');
    }

    // --- MÉTODOS DE LA BITÁCORA ---
    public function showBitacora(Asset $asset)
    {
        $asset->load(['maintenanceReports' => function ($query) {
            $query->orderBy('created_at', 'desc');
        }, 'sede.ips']);
        return view('assets.bitacora', ['asset' => $asset]);
    }

    public function storeBitacoraEntry(Request $request, Asset $asset)
    {
        $request->validate([
            'created_at' => 'required|date',
            'tipo_mantenimiento' => 'required|string',
            'manual_responsable' => 'required|string',
            'next_intervention_date' => 'nullable|date',
        ]);

        $asset->maintenanceReports()->create([
            'is_manual_entry' => true,
            'tecnico_id' => Auth::id(),
            'created_at' => $request->created_at,
            'tipo_mantenimiento' => $request->tipo_mantenimiento,
            'manual_responsable' => $request->manual_responsable,
            'next_intervention_date' => $request->next_intervention_date,
        ]);
        
        return redirect()->route('assets.bitacora', $asset->id)->with('success', 'Entrada manual añadida a la bitácora.');
    }

    public function downloadBitacoraPDF(Asset $asset)
    {
        $asset->load(['maintenanceReports' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }, 'sede.ips', 'servicio']);
        $pdf = PDF::loadView('assets.bitacora-pdf', ['asset' => $asset]);
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('bitacora-' . $asset->nombre_equipo . '.pdf');
    }
    
    // --- MÉTODOS PARA API INTERNA ---
    
    /**
     * Devuelve una lista de activos en formato JSON para una sede específica.
     */
    public function getAssetsBySede(Sede $sede)
    {
        return response()->json($sede->assets()->orderBy('nombre_equipo')->get());
    }

    /**
     * Busca activos para la funcionalidad de autocompletar.
     */
    public function searchAssets(Request $request)
    {
        $query = $request->input('q');
        if (!$query) {
            return response()->json([]);
        }

        $assets = Asset::with(['sede', 'servicio'])
            ->where('nombre_equipo', 'LIKE', "%{$query}%")
            ->orWhere('marca', 'LIKE', "%{$query}%")
            ->orWhere('modelo', 'LIKE', "%{$query}%")
            ->orWhere('serie', 'LIKE', "%{$query}%")
            ->orWhereHas('sede', function ($q) use ($query) {
                $q->where('nombre_sede', 'LIKE', "%{$query}%");
            })
            ->orWhereHas('servicio', function ($q) use ($query) {
                $q->where('nombre_servicio', 'LIKE', "%{$query}%");
            })
            ->take(15) // Limitar resultados para no sobrecargar
            ->get();

        return response()->json($assets);
    }

    /**
     * Devuelve los detalles de un activo específico en JSON.
     */
      public function getAssetDetails(Asset $asset)
    {
        // Cargamos las relaciones para tener sede_id, servicio_id, etc.
        $asset->load(['sede', 'servicio', 'zona']); 
        return response()->json($asset);
    }
}
