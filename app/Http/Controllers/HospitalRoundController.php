<?php

namespace App\Http\Controllers;

use App\Models\HospitalRound;
use App\Models\Sede;
use App\Models\Asset;
use App\Models\MaintenanceRequest;
use App\Models\TaskTeam;
use App\Models\User;
use App\Notifications\NewFailureNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class HospitalRoundController extends Controller
{
    public function index()
    {
        // Cargamos las relaciones para poder acceder a ellas en la vista
        $rounds = HospitalRound::with(['user', 'sede', 'servicio', 'asset'])->latest()->get();
        return view('hospital-rounds.index', ['rounds' => $rounds]);
    }

    public function create()
    {
        $sedes = Sede::orderBy('nombre_sede')->get();
        return view('hospital-rounds.create', ['sedes' => $sedes]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sede_id' => 'required|exists:sedes,id',
            'servicio_id' => 'required|exists:servicios,id',
            'zona_id' => 'nullable|exists:zonas,id',
            'found_failures' => 'required|boolean',
            'asset_id' => 'required_if:found_failures,1|nullable|exists:assets,id',
            'failure_description' => 'required_if:found_failures,1|nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'observations' => 'nullable|string',
            'responsible_name' => 'required|string|max:255',
            'responsible_signature' => 'nullable|string',
        ]);

        // Guardar Firma
        $signaturePath = null;
        if ($request->filled('responsible_signature')) {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->responsible_signature));
            $signaturePath = 'firmas_rondas/' . uniqid() . '.png';
            Storage::disk('public')->put($signaturePath, $imageData);
        }

        // Guardar Imagen
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rondas_imagenes', 'public');
        }

        $maintenanceRequestId = null;

        // LÓGICA CLAVE: Si se encontraron fallas, crear el reporte de mantenimiento
        if ($validated['found_failures']) {
            $maintenanceRequest = MaintenanceRequest::create([
                'user_id' => Auth::id(),
                'asset_id' => $validated['asset_id'],
                'solicitante_nombre' => 'Hallazgo en Ronda Hospitalaria',
                'ubicacion_texto' => $request->input('ubicacion_texto_hidden', 'No especificada'),
                'descripcion' => $validated['failure_description'],
                'imagen_url' => $imagePath,
                'estado' => 'Pendiente',
            ]);
            $maintenanceRequestId = $maintenanceRequest->id;

            // Notificar al equipo de tarea asignado
            $this->notifyTeam($maintenanceRequest);
        }

        // Crear el registro de la ronda
        HospitalRound::create([
            'user_id' => Auth::id(),
            'sede_id' => $validated['sede_id'],
            'servicio_id' => $validated['servicio_id'],
            'zona_id' => $validated['zona_id'],
            'asset_id' => $validated['asset_id'],
            'found_failures' => $validated['found_failures'],
            'failure_description' => $validated['failure_description'],
            'image_url' => $imagePath,
            'observations' => $validated['observations'],
            'responsible_name' => $validated['responsible_name'],
            'responsible_signature' => $signaturePath,
            'maintenance_request_id' => $maintenanceRequestId,
        ]);

        return redirect()->route('hospital-rounds.index')->with('success', 'Ronda hospitalaria registrada exitosamente.');
    }

    /**
     * Notifica al equipo de tarea correspondiente sobre una nueva falla.
     */
    private function notifyTeam(MaintenanceRequest $maintenanceRequest)
    {
        $asset = Asset::with(['sede', 'servicio'])->find($maintenanceRequest->asset_id);
        $teamToNotify = null;

        if ($asset) {
            // Buscar equipo por servicio específico
            if ($asset->servicio_id) {
                $teamToNotify = TaskTeam::whereHas('services', function ($query) use ($asset) {
                    $query->where('servicios.id', $asset->servicio_id);
                })->with('users')->first();
            }
            // Si no, buscar por sede
            if (!$teamToNotify && $asset->sede_id) {
                $teamToNotify = TaskTeam::whereHas('sedes', function ($query) use ($asset) {
                    $query->where('sedes.id', $asset->sede_id);
                })->with('users')->first();
            }
        }
        
        // Notificar a los miembros del equipo encontrado O a los administradores
        $recipients = ($teamToNotify && $teamToNotify->users->isNotEmpty()) 
            ? $teamToNotify->users
            : User::where('rol_id', 1)->get(); // Rol 1 = Super Admin

        if ($recipients->isNotEmpty()) {
            Notification::send($recipients, new NewFailureNotification($maintenanceRequest));
        }
    }

    /**
     * Muestra los detalles de una ronda específica (especialmente las que tuvieron fallas).
     */
    public function show(HospitalRound $hospitalRound)
    {
        $hospitalRound->load(['user', 'sede', 'servicio', 'zona', 'asset', 'maintenanceRequest']);
        return view('hospital-rounds.show', compact('hospitalRound'));
    }
}