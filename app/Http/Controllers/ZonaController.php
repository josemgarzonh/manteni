<?php

namespace App\Http\Controllers;

use App\Models\Zona;
use App\Models\Sede;
use App\Models\Servicio;
use Illuminate\Http\Request;

class ZonaController extends Controller
{
    public function index()
    {
        $zonas = Zona::with(['sede', 'servicio'])->get();
        return view('zonas.index', compact('zonas'));
    }

    public function create()
    {
        $sedes = Sede::orderBy('nombre_sede')->get();
        // Ya no es necesario pasar todos los servicios, se cargarán dinámicamente con JavaScript.
        return view('zonas.create', compact('sedes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sede_id' => 'required|exists:sedes,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'nombre_zona' => 'required|string|max:255',
        ]);
        Zona::create($validated);
        return redirect()->route('zonas.index')->with('success', 'Zona creada exitosamente.');
    }

    public function edit(Zona $zona)
    {
        $sedes = Sede::orderBy('nombre_sede')->get();
        // Ya no es necesario pasar todos los servicios, se cargarán dinámicamente con JavaScript.
        return view('zonas.edit', compact('zona', 'sedes'));
    }

    public function update(Request $request, Zona $zona)
    {
        $validated = $request->validate([
            'sede_id' => 'required|exists:sedes,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'nombre_zona' => 'required|string|max:255',
        ]);
        $zona->update($validated);
        return redirect()->route('zonas.index')->with('success', 'Zona actualizada exitosamente.');
    }

    public function destroy(Zona $zona)
    {
        $zona->delete();
        return redirect()->route('zonas.index')->with('success', 'Zona eliminada exitosamente.');
    }
}
