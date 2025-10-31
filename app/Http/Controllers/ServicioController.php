<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Sede;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::with('sede')->get();
        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        $sedes = Sede::all();
        return view('servicios.create', compact('sedes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sede_id' => 'required|exists:sedes,id',
            'nombre_servicio' => 'required|string|max:255',
            'codigo_servicio' => 'nullable|string|max:255',
            'grupo_servicio' => 'nullable|string|max:255',
        ]);
        Servicio::create($validated);
        return redirect()->route('servicios.index')->with('success', 'Servicio creado exitosamente.');
    }

    public function edit(Servicio $servicio)
    {
        $sedes = Sede::all();
        return view('servicios.edit', compact('servicio', 'sedes'));
    }

    public function update(Request $request, Servicio $servicio)
    {
        $validated = $request->validate([
            'sede_id' => 'required|exists:sedes,id',
            'nombre_servicio' => 'required|string|max:255',
            'codigo_servicio' => 'nullable|string|max:255',
            'grupo_servicio' => 'nullable|string|max:255',
        ]);
        $servicio->update($validated);
        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado exitosamente.');
    }

    public function destroy(Servicio $servicio)
    {
        $servicio->delete();
        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado exitosamente.');
    }

    /**
     * Devuelve los equipos de un servicio para llamadas API.
     */
    public function getAssetsForServicio(Servicio $servicio)
    {
        return response()->json($servicio->assets()->orderBy('nombre_equipo')->get());
    }
}
