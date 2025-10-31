<?php
// app/Http/Controllers/ScheduleController.php

namespace App\Http\Controllers;

use App\Models\ScheduledActivity;
use App\Models\ActivityReminder;
use App\Models\Asset;
use App\Models\Sede;
use App\Models\Servicio;
use App\Models\Zona;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    public function calendar(Request $request)
    {
        $activities = ScheduledActivity::with(['assignedUser', 'asset', 'sede', 'servicio'])
            ->when($request->type, function($q, $type) {
                return $q->where('activity_type', $type);
            })
            ->when($request->sede_id, function($q, $sedeId) {
                return $q->where('sede_id', $sedeId);
            })
            ->when($request->servicio_id, function($q, $servicioId) {
                return $q->where('servicio_id', $servicioId);
            })
            ->when($request->priority, function($q, $priority) {
                return $q->where('priority', $priority);
            })
            ->get()
            ->map(function($activity) {
                return [
                    'id' => $activity->id,
                    'title' => $activity->title,
                    'start' => $activity->start_date->toIso8601String(),
                    'end' => $activity->end_date->toIso8601String(),
                    'color' => $this->getActivityColor($activity->activity_type),
                    'extendedProps' => [
                        'type' => $activity->activity_type,
                        'type_label' => $activity->activity_type_label,
                        'assigned_to' => $activity->assignedUser->name,
                        'status' => $activity->status,
                        'priority' => $activity->priority,
                        'asset' => $activity->asset ? $activity->asset->nombre_equipo : null,
                    ]
                ];
            });

        $sedes = Sede::all();
        $servicios = Servicio::all();
        $users = User::all();

        return view('schedules.calendar', compact('activities', 'sedes', 'servicios', 'users'));
    }

    public function index(Request $request)
    {
        $query = ScheduledActivity::with(['assignedUser', 'asset', 'sede', 'servicio'])
            ->when($request->type, function($q, $type) {
                return $q->where('activity_type', $type);
            })
            ->when($request->sede_id, function($q, $sedeId) {
                return $q->where('sede_id', $sedeId);
            })
            ->when($request->status, function($q, $status) {
                return $q->where('status', $status);
            });

        $activities = $query->latest()->paginate(20);
        $sedes = Sede::all();
        $servicios = Servicio::all();

        return view('schedules.index', compact('activities', 'sedes', 'servicios'));
    }

    public function create()
    {
        $assets = Asset::all();
        $sedes = Sede::all();
        $servicios = Servicio::all();
        $zonas = Zona::all();
        $users = User::all();

        return view('schedules.create', compact('assets', 'sedes', 'servicios', 'zonas', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'activity_type' => 'required|in:hospital_round,defibrillator_test,preventive_maintenance,calibration,training,intervention,failure_attention',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'priority' => 'required|in:low,medium,high,urgent',
            'asset_id' => 'nullable|exists:assets,id',
            'assigned_to' => 'required|exists:users,id',
            'sede_id' => 'nullable|exists:sedes,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'zone_id' => 'nullable|exists:zonas,id',
            'reminders' => 'nullable|array',
            'reminders.*' => 'integer|in:15,30,60,1440'
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = 'pending';

        $activity = ScheduledActivity::create($validated);

        // Crear recordatorios
        if ($request->has('reminders')) {
            foreach ($request->reminders as $minutes) {
                ActivityReminder::create([
                    'scheduled_activity_id' => $activity->id,
                    'remind_minutes_before' => $minutes
                ]);
            }
        }

        return redirect()->route('schedules.calendar')
            ->with('success', 'Actividad programada creada exitosamente.');
    }

    public function show(ScheduledActivity $schedule)
    {
        $schedule->load(['assignedUser', 'creator', 'asset', 'sede', 'servicio', 'zone', 'reminders']);
        return view('schedules.show', compact('schedule'));
    }

    public function edit(ScheduledActivity $schedule)
    {
        $assets = Asset::all();
        $sedes = Sede::all();
        $servicios = Servicio::all();
        $zonas = Zona::all();
        $users = User::all();

        return view('schedules.edit', compact('schedule', 'assets', 'sedes', 'servicios', 'zonas', 'users'));
    }

    public function update(Request $request, ScheduledActivity $schedule)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'activity_type' => 'required|in:hospital_round,defibrillator_test,preventive_maintenance,calibration,training,intervention,failure_attention',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'priority' => 'required|in:low,medium,high,urgent',
            'asset_id' => 'nullable|exists:assets,id',
            'assigned_to' => 'required|exists:users,id',
            'sede_id' => 'nullable|exists:sedes,id',
            'servicio_id' => 'nullable|exists:servicios,id',
            'zone_id' => 'nullable|exists:zonas,id',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.show', $schedule)
            ->with('success', 'Actividad actualizada exitosamente.');
    }

    public function destroy(ScheduledActivity $schedule)
    {
        $schedule->delete();

        return redirect()->route('schedules.index')
            ->with('success', 'Actividad eliminada exitosamente.');
    }

    public function updateStatus(Request $request, ScheduledActivity $schedule)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled'
        ]);

        $schedule->update(['status' => $request->status]);

        return back()->with('success', 'Estado de la actividad actualizado.');
    }

    private function getActivityColor($type)
    {
        return match($type) {
            'hospital_round' => '#3B82F6',
            'defibrillator_test' => '#10B981',
            'preventive_maintenance' => '#F59E0B',
            'calibration' => '#8B5CF6',
            'training' => '#EC4899',
            'intervention' => '#EF4444',
            'failure_attention' => '#DC2626',
            default => '#6B7280'
        };
    }
}