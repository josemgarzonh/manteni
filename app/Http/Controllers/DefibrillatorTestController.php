<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\DefibrillatorTest;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DefibrillatorTestController extends Controller
{
    public function index()
    {
        $tests = DefibrillatorTest::with(['asset', 'user', 'servicio'])->latest()->get();
        return view('defibrillator-tests.index', ['tests' => $tests]);
    }

    public function create()
    {
        $defibrillators = Asset::where('specific_type', 'Desfibrilador')->get();
        $servicios = Servicio::all();

        return view('defibrillator-tests.create', [
            'defibrillators' => $defibrillators,
            'servicios' => $servicios
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'servicio_id' => 'required|exists:servicios,id',
            'criterio_1_estado_externo' => 'required|boolean',
            'criterio_2_limpieza_palas' => 'required|boolean',
            'criterio_3_nivel_bateria' => 'required|boolean',
            'criterio_4_papel_registrador' => 'required|boolean',
            'criterio_5_test_descarga' => 'required|boolean',
            'observaciones' => 'nullable|string',
            'responsable_servicio_nombre' => 'required|string|max:255',
            'signature' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:10240'
        ]);

        // Guardar la firma digital
        $signaturePath = null;
        if ($request->filled('signature')) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->signature));
            $signaturePath = 'firmas_tests/' . uniqid() . '.png';
            Storage::disk('public')->put($signaturePath, $imageData);
        }

        // --- LÓGICA CORREGIDA ---
        // Preparamos los datos para la tabla principal, excluyendo los campos que no pertenecen a ella.
        $dataToCreate = $validated;
        unset($dataToCreate['signature']); // Quitar la data de la firma
        unset($dataToCreate['photos']); // Quitar el array de fotos
        
        $dataToCreate['user_id'] = Auth::id();
        $dataToCreate['responsable_servicio_firma_url'] = $signaturePath; // Añadir la ruta de la firma

        // Crear el registro del test con los datos correctos
        $test = DefibrillatorTest::create($dataToCreate);

        // Guardar las fotos adjuntas
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $photoPath = $photo->store('fotos_tests', 'public');
                $test->images()->create(['image_url' => $photoPath]);
            }
        }

        return redirect()->route('defibrillator-tests.index')->with('success', 'Test de Desfibrilador guardado exitosamente.');
    }
}