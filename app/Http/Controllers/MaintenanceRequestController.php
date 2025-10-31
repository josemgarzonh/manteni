<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sede;
use App\Models\Asset;
use App\Models\TaskTeam; // <-- AÑADIR ESTO
use App\Notifications\NewFailureNotification; // <-- AÑADIR ESTO
use Illuminate\Support\Facades\Notification; // <-- AÑADIR ESTO

class MaintenanceRequestController extends Controller
{
    // ... los métodos index() y create() se quedan igual ...
    public function index()
    {
        $requests = MaintenanceRequest::with(['user', 'asset'])->latest()->get();
        return view('maintenance-requests.index', ['requests' => $requests]);
    }

    public function create()
    {
        $sedes = Sede::orderBy('nombre_sede')->get();
        return view('maintenance-requests.create', ['sedes' => $sedes]);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'solicitante_nombre' => 'required_if:user_id,null|string|max:255',
            'ubicacion_texto' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Tamaño aumentado
        ]);

        $imagePath = null;
        if ($request->hasFile('imagen')) {
            $imagePath = $request->file('imagen')->store('fallas_imagenes', 'public');
        }

        $newRequest = MaintenanceRequest::create([
            'user_id' => Auth::id(),
            'asset_id' => $validatedData['asset_id'],
            'solicitante_nombre' => $validatedData['solicitante_nombre'] ?? null,
            'ubicacion_texto' => $validatedData['ubicacion_texto'],
            'descripcion' => $validatedData['descripcion'],
            'imagen_url' => $imagePath,
            'estado' => 'Pendiente',
        ]);

        // --- INICIO DE LA NUEVA LÓGICA DE ASIGNACIÓN AUTOMÁTICA ---
        $asset = Asset::with(['sede', 'servicio'])->find($validatedData['asset_id']);
        $teamToNotify = null;

        if ($asset) {
            // 1. Buscar un equipo asignado al SERVICIO específico
            if ($asset->servicio_id) {
                $teamToNotify = TaskTeam::whereHas('services', function ($query) use ($asset) {
                    $query->where('servicios.id', $asset->servicio_id);
                })->with('users')->first();
            }

            // 2. Si no se encontró por servicio, buscar por SEDE
            if (!$teamToNotify && $asset->sede_id) {
                $teamToNotify = TaskTeam::whereHas('sedes', function ($query) use ($asset) {
                    $query->where('sedes.id', $asset->sede_id);
                })->with('users')->first();
            }
        }
        
        $admins = User::where('rol_id', 1)->get(); // Rol 1 = Super Administrador

        if ($teamToNotify && $teamToNotify->users->isNotEmpty()) {
            // Si se encontró un equipo, se notifica a sus miembros
            Notification::send($teamToNotify->users, new NewFailureNotification($newRequest));
            // También notificamos a los administradores
            Notification::send($admins, new NewFailureNotification($newRequest));

        } else {
            // Si no hay equipo, se notifica solo a los administradores (comportamiento por defecto)
            Notification::send($admins, new NewFailureNotification($newRequest));
        }
        // --- FIN DE LA NUEVA LÓGICA ---

        return redirect()->route('maintenance-requests.create')->with('success', '¡Solicitud enviada exitosamente! El equipo de tarea ha sido notificado.');
    }

    // ... los métodos show() y assign() se quedan igual para asignación manual ...
    public function show(MaintenanceRequest $request)
    {
        $technicians = User::whereIn('rol_id', [6, 7])->orderBy('name')->get();
        return view('maintenance-requests.show', [
            'request' => $request,
            'technicians' => $technicians
        ]);
    }

    public function assign(Request $requestData, MaintenanceRequest $request)
    {
        $requestData->validate(['assigned_to' => 'required|exists:users,id']);
        $request->update([
            'estado' => 'Asignada',
            'assigned_to' => $requestData->assigned_to
        ]);
        return redirect()->route('maintenance-requests.index')->with('success', 'Solicitud asignada manualmente.');
    }
}