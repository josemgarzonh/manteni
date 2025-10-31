<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\BiomedicalDetail;
use Illuminate\Http\Request;

class BiomedicalDetailController extends Controller
{
    /**
     * Muestra el formulario para crear los detalles de la hoja de vida.
     */
    public function create(Asset $asset)
    {
        return view('assets.biomedical-details.create', ['asset' => $asset]);
    }

    /**
     * Guarda los detalles de la hoja de vida en la base de datos.
     */
    public function store(Request $request, Asset $asset)
    {
        // Esta validación es para el formulario simple inicial, la lógica principal
        // ahora está en updateHojaDeVida del AssetController.
        $validatedData = $request->validate([
            'clasificacion_riesgo' => 'nullable|string',
            'clasificacion_uso' => 'nullable|string',
            'tecnologia_predominante' => 'nullable|string',
            'fabricante' => 'nullable|string',
            'registro_invima' => 'nullable|string',
            'componentes_accesorios' => 'nullable|string',
            'rango_voltaje' => 'nullable|string',
            'rango_corriente' => 'nullable|string',
            'rango_potencia' => 'nullable|string',
            'rango_frecuencia' => 'nullable|string',
            'rango_presion' => 'nullable|string',
            'rango_temperatura' => 'nullable|string',
            'rango_humedad' => 'nullable|string',
            'peso' => 'nullable|string',
        ]);
    
        $asset->biomedicalDetail()->updateOrCreate(['asset_id' => $asset->id], $validatedData);
    
        return redirect()->route('assets.hoja-de-vida.show', $asset->id)->with('success', 'Hoja de Vida completada exitosamente.');
    }
}
