<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequest;
use App\Models\FailureAttention;
use App\Models\SparePartRequest;
use App\Models\User;
use App\Notifications\FailureAttendedNotification;
use App\Notifications\NewSparePartRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class FailureController extends Controller
{
    /**
     * Muestra el "Listado de Fallas" para administradores.
     */
    public function index()
    {
        $failures = MaintenanceRequest::with(['user', 'asset', 'attentions.technician'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('failures.index', compact('failures'));
    }

    /**
     * Muestra el formulario "Atención de Fallas" para un reporte específico.
     */
    public function attend(MaintenanceRequest $maintenanceRequest)
    {
        $maintenanceRequest->load('asset', 'user', 'attentions.technician', 'attentions.images');
        return view('failures.attend', compact('maintenanceRequest'));
    }

    /**
     * Guarda una nueva entrada de atención de falla.
     */
    public function storeAttention(Request $request, MaintenanceRequest $maintenanceRequest)
    {
        $validated = $request->validate([
            'detalles_tecnicos' => 'required|string',
            'estado_falla' => 'required|in:activa,en espera,postergada,despejada',
            'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'repuestos' => 'nullable|array',
            'repuestos.*.part_name' => 'required_with:repuestos|string|max:255',
            'repuestos.*.quantity' => 'required_with:repuestos|integer|min:1',
            'repuestos.*.photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        // Marcar la fecha de la primera atención si no ha sido marcada antes
        if (!$maintenanceRequest->attended_at) {
            $maintenanceRequest->attended_at = Carbon::now();
        }

        // Actualizar el estado general de la falla en la solicitud principal
        $maintenanceRequest->estado_falla = $validated['estado_falla'];
        $maintenanceRequest->estado = ($validated['estado_falla'] == 'despejada') ? 'Finalizada' : 'En Proceso';
        $maintenanceRequest->save();

        // Crear el registro de la atención específica
        $attention = $maintenanceRequest->attentions()->create([
            'user_id' => Auth::id(),
            'detalles_tecnicos' => $validated['detalles_tecnicos'],
            'estado_falla' => $validated['estado_falla'],
        ]);

        // Guardar imágenes de la atención
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $file) {
                $path = $file->store('atencion_fallas', 'public');
                $attention->images()->create(['image_url' => $path]);
            }
        }

        // Guardar solicitudes de repuestos y notificar
        if ($request->has('repuestos')) {
            foreach ($request->repuestos as $index => $repuestoData) {
                $photoPath = null;
                if ($request->hasFile("repuestos.{$index}.photo")) {
                    $photoPath = $request->file("repuestos.{$index}.photo")->store('repuestos_fotos', 'public');
                }
                $sparePartRequest = SparePartRequest::create([
                    'maintenance_report_id' => null, // Opcional: podrías asociarlo a un reporte si se genera después
                    'user_id' => Auth::id(),
                    'asset_id' => $maintenanceRequest->asset_id,
                    'part_name' => $repuestoData['part_name'],
                    'quantity' => $repuestoData['quantity'],
                    'photo_url' => $photoPath,
                    'status' => 'solicitado',
                ]);

                // Notificar a los administradores sobre el nuevo repuesto
                $admins = User::where('rol_id', 1)->get(); // Asumiendo rol_id 1 = Super Administrador
                Notification::send($admins, new NewSparePartRequestNotification($sparePartRequest));
            }
        }

        // Notificar al usuario que reportó la falla (si existe)
        if ($maintenanceRequest->user) {
            Notification::send($maintenanceRequest->user, new FailureAttendedNotification($attention));
        }

        return redirect()->route('failures.index')->with('success', 'Atención de falla registrada exitosamente.');
    }
}