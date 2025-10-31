<?php

namespace App\Http\Controllers;

use App\Models\TaskTeam;
use App\Models\User;
use App\Models\Zona;
use App\Models\Servicio;
use App\Models\Sede; // <-- AÑADIR ESTO
use Illuminate\Http\Request;

class TaskTeamController extends Controller
{
    public function index()
    {
        // --- MODIFICADO para incluir sedes ---
        $taskTeams = TaskTeam::with(['users', 'zonas', 'services', 'sedes'])->get();
        return view('task-teams.index', compact('taskTeams'));
    }

    public function create()
    {
        $users = User::whereIn('rol_id', [6, 7])->orderBy('name')->get();
        $zonas = Zona::orderBy('nombre_zona')->get();
        $servicios = Servicio::orderBy('nombre_servicio')->get();
        $sedes = Sede::orderBy('nombre_sede')->get(); // <-- AÑADIR ESTO

        // --- MODIFICADO para pasar sedes a la vista ---
        return view('task-teams.create', compact('users', 'zonas', 'servicios', 'sedes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_equipo' => 'required|string|max:255',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
            'sedes' => 'nullable|array', // <-- AÑADIR ESTO
            'sedes.*' => 'exists:sedes,id', // <-- AÑADIR ESTO
            'zonas' => 'nullable|array',
            'zonas.*' => 'exists:zonas,id',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicios,id',
        ]);

        $taskTeam = TaskTeam::create($validated);

        $taskTeam->users()->sync($validated['users'] ?? []);
        $taskTeam->sedes()->sync($validated['sedes'] ?? []); // <-- AÑADIR ESTO
        $taskTeam->zonas()->sync($validated['zonas'] ?? []);
        $taskTeam->services()->sync($validated['servicios'] ?? []);

        return redirect()->route('task-teams.index')->with('success', 'Equipo de tarea creado exitosamente.');
    }

    public function edit(TaskTeam $taskTeam)
    {
        $users = User::whereIn('rol_id', [6, 7])->orderBy('name')->get();
        $zonas = Zona::orderBy('nombre_zona')->get();
        $servicios = Servicio::orderBy('nombre_servicio')->get();
        $sedes = Sede::orderBy('nombre_sede')->get(); // <-- AÑADIR ESTO

        // --- MODIFICADO para cargar sedes ---
        $taskTeam->load(['users', 'zonas', 'services', 'sedes']);

        // --- MODIFICADO para pasar sedes a la vista ---
        return view('task-teams.edit', compact('taskTeam', 'users', 'zonas', 'servicios', 'sedes'));
    }

    public function update(Request $request, TaskTeam $taskTeam)
    {
        $validated = $request->validate([
            'nombre_equipo' => 'required|string|max:255',
            'users' => 'nullable|array',
            'users.*' => 'exists:users,id',
            'sedes' => 'nullable|array', // <-- AÑADIR ESTO
            'sedes.*' => 'exists:sedes,id', // <-- AÑADIR ESTO
            'zonas' => 'nullable|array',
            'zonas.*' => 'exists:zonas,id',
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicios,id',
        ]);

        $taskTeam->update($validated);

        $taskTeam->users()->sync($validated['users'] ?? []);
        $taskTeam->sedes()->sync($validated['sedes'] ?? []); // <-- AÑADIR ESTO
        $taskTeam->zonas()->sync($validated['zonas'] ?? []);
        $taskTeam->services()->sync($validated['servicios'] ?? []);

        return redirect()->route('task-teams.index')->with('success', 'Equipo de tarea actualizado exitosamente.');
    }

    public function destroy(TaskTeam $taskTeam)
    {
        $taskTeam->delete();
        return redirect()->route('task-teams.index')->with('success', 'Equipo de tarea eliminado exitosamente.');
    }
}