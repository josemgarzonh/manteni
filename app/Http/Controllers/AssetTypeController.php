<?php

namespace App\Http\Controllers;

use App\Models\AssetType;
use Illuminate\Http\Request;

class AssetTypeController extends Controller
{
    public function index()
    {
        $assetTypes = AssetType::all();
        return view('asset-types.index', compact('assetTypes'));
    }

    public function create()
    {
        return view('asset-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate(['nombre' => 'required|string|unique:asset_types,nombre|max:255']);
        AssetType::create($validated);
        return redirect()->route('asset-types.index')->with('success', 'Tipo de activo creado exitosamente.');
    }

    public function edit(AssetType $assetType)
    {
        return view('asset-types.edit', compact('assetType'));
    }

    public function update(Request $request, AssetType $assetType)
    {
        $validated = $request->validate(['nombre' => 'required|string|unique:asset_types,nombre,' . $assetType->id . '|max:255']);
        $assetType->update($validated);
        return redirect()->route('asset-types.index')->with('success', 'Tipo de activo actualizado exitosamente.');
    }

    public function destroy(AssetType $assetType)
    {
        $assetType->delete();
        return redirect()->route('asset-types.index')->with('success', 'Tipo de activo eliminado exitosamente.');
    }
}