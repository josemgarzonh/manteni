<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use App\Models\Ips;
use Illuminate\Http\Request;

class SedeController extends Controller
{
    public function index()
    {
        $sedes = Sede::with('ips')->get(); // Cargar la relación con IPS
        return view('sedes.index', compact('sedes'));
    }

    public function create()
    {
        $ips = Ips::all(); // Obtener todas las IPS para el menú desplegable
        return view('sedes.create', compact('ips'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ips_id' => 'required|exists:ips,id',
            'nombre_sede' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:255',
        ]);
        Sede::create($validated);
        return redirect()->route('sedes.index')->with('success', 'Sede creada exitosamente.');
    }

    public function edit(Sede $sede)
    {
        $ips = Ips::all();
        return view('sedes.edit', compact('sede', 'ips'));
    }

    public function update(Request $request, Sede $sede)
    {
        $validated = $request->validate([
            'ips_id' => 'required|exists:ips,id',
            'nombre_sede' => 'required|string|max:255',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:255',
        ]);
        $sede->update($validated);
        return redirect()->route('sedes.index')->with('success', 'Sede actualizada exitosamente.');
    }

    public function destroy(Sede $sede)
    {
        $sede->delete();
        return redirect()->route('sedes.index')->with('success', 'Sede eliminada exitosamente.');
    }

    /**
     * Devuelve los servicios de una sede para llamadas API.
     */
    public function getServiciosForSede(Sede $sede)
    {
        return response()->json($sede->servicios()->orderBy('nombre_servicio')->get());
    }

    /**
     * Devuelve las zonas de una sede para llamadas API.
     */
    public function getZonasForSede(Sede $sede)
    {
        return response()->json($sede->zonas()->orderBy('nombre_zona')->get());
    }
}

