<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\MaintenanceSchedule;
use Illuminate\Http\Request;

class MaintenanceScheduleController extends Controller
{
    public function index()
    {
        $schedules = MaintenanceSchedule::with('asset')->orderBy('next_due_date')->get();
        return view('schedules.index', ['schedules' => $schedules]);
    }

    public function create()
    {
        $assets = Asset::orderBy('nombre_equipo')->get();
        return view('schedules.create', ['assets' => $assets]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'task' => 'required|string|max:255',
            'frequency_days' => 'required|integer|min:1',
            'next_due_date' => 'required|date',
        ]);

        MaintenanceSchedule::create($request->all());

        return redirect()->route('schedules.index')->with('success', 'Nueva tarea de mantenimiento programada exitosamente.');
    }

    /**
     * Muestra el formulario para editar una tarea programada.
     */
    public function edit(MaintenanceSchedule $schedule)
    {
        $assets = Asset::orderBy('nombre_equipo')->get();
        return view('schedules.edit', [
            'schedule' => $schedule,
            'assets' => $assets
        ]);
    }

    /**
     * Actualiza una tarea programada en la base de datos.
     */
    public function update(Request $request, MaintenanceSchedule $schedule)
    {
        $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'task' => 'required|string|max:255',
            'frequency_days' => 'required|integer|min:1',
            'next_due_date' => 'required|date',
        ]);

        $schedule->update($request->all());

        return redirect()->route('schedules.index')->with('success', 'Tarea programada actualizada exitosamente.');
    }

    /**
     * Elimina una tarea programada de la base de datos.
     */
    public function destroy(MaintenanceSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Tarea programada eliminada exitosamente.');
    }
}