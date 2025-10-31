<?php
namespace App\Http\Controllers;
use App\Models\Ips;
use Illuminate\Http\Request;

class IpsController extends Controller
{
    public function index() {
        $ips = Ips::all();
        return view('ips.index', compact('ips'));
    }

    public function create() {
        return view('ips.create');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nombre_prestador' => 'required|string|max:255',
            'nit' => 'required|string|unique:ips,nit',
            // --- LÍNEAS AÑADIDAS ---
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'razon_social' => 'nullable|string|max:255',
        ]);
        Ips::create($validated);
        return redirect()->route('ips.index')->with('success', 'IPS creada exitosamente.');
    }

    public function edit(Ips $ip) {
        return view('ips.edit', compact('ip'));
    }

    public function update(Request $request, Ips $ip) {
        $validated = $request->validate([
            'nombre_prestador' => 'required|string|max:255',
            'nit' => 'required|string|unique:ips,nit,' . $ip->id,
            // --- LÍNEAS AÑADIDAS ---
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'razon_social' => 'nullable|string|max:255',
        ]);
        $ip->update($validated);
        return redirect()->route('ips.index')->with('success', 'IPS actualizada exitosamente.');
    }

    public function destroy(Ips $ip) {
        $ip->delete();
        return redirect()->route('ips.index')->with('success', 'IPS eliminada exitosamente.');
    }
}