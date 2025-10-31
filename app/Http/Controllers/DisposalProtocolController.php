<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\DisposalProtocol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DisposalProtocolController extends Controller
{
    public function create(Asset $asset)
    {
        return view('disposal-protocols.create', ['asset' => $asset]);
    }

    public function store(Request $request, Asset $asset)
    {
        $validatedData = $request->validate([
            // Validaciones para todos los campos del formulario...
            'T_edad' => 'required|integer|min:0|max:10',
            'T_soporte_refacciones' => 'required|integer|min:0|max:10',
            'T_soporte_consumibles' => 'required|integer|min:0|max:10',
            'T_soporte_tecnico' => 'required|integer|min:0|max:10',
            'C_facilidad_uso' => 'required|integer|min:0|max:10',
            'C_satisface_necesidades' => 'required|integer|min:0|max:10',
            'C_confianza_resultados' => 'required|integer|min:0|max:10',
            'C_contribuye_practica' => 'required|integer|min:0|max:10',
            'C_tiempo_reparacion_largo' => 'required|integer|min:0|max:10',
            'C_frecuencia_uso_apropiada' => 'required|integer|min:0|max:10',
            'E_costo_mantenimiento' => 'required|numeric|min:0',
            'E_costo_sustitucion' => 'required|numeric|min:1', // Evitar división por cero
        ]);

        // --- Cálculos ---
        $score_T = ($validatedData['T_edad'] + $validatedData['T_soporte_refacciones'] + $validatedData['T_soporte_consumibles'] + $validatedData['T_soporte_tecnico']) / 4;
        $score_C = ($validatedData['C_facilidad_uso'] + $validatedData['C_satisface_necesidades'] + $validatedData['C_confianza_resultados'] + $validatedData['C_contribuye_practica'] + $validatedData['C_tiempo_reparacion_largo'] + $validatedData['C_frecuencia_uso_apropiada']) / 6;

        // Cálculo del CMS y conversión a una escala de 10
        $cms = ($validatedData['E_costo_mantenimiento'] / $validatedData['E_costo_sustitucion']) * 100;
        $score_E = max(0, 10 - ($cms / 10)); // Asumimos que un CMS del 100% o más es la peor puntuación (0)

        // Fórmula Final V
        $score_V_final = (4.5 * $score_T) + (3.0 * $score_C) + (2.5 * $score_E);

        // Determinación de la Recomendación
        if ($score_V_final < 60) {
            $recommendation = 'Reemplazo inmediato';
        } elseif ($score_V_final >= 60 && $score_V_final <= 70) {
            $recommendation = 'Reevaluación en 1.5 años';
        } else {
            $recommendation = 'Reevaluación en 3 años';
        }

        $protocol = DisposalProtocol::create(array_merge($validatedData, [
            'asset_id' => $asset->id,
            'user_id' => Auth::id(),
            'score_V_final' => $score_V_final,
            'recommendation' => $recommendation,
        ]));

        return redirect()->route('disposal-protocols.show', $protocol->id);
    }

    public function show(DisposalProtocol $protocol)
    {
        return view('disposal-protocols.show', ['protocol' => $protocol]);
    }
}