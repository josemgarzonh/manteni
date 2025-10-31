<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
            {
                 // Usamos with('role') para cargar la relación eficientemente
                $users = \App\Models\User::with('role')->get();
            
                // 2. Devolvemos la vista y le pasamos la variable $users
                return view('users.index', ['users' => $users]);
            }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
            {
                // 1. Obtenemos todos los roles para pasarlos al formulario
                $roles = \App\Models\Role::all();
            
                // 2. Devolvemos la vista del formulario con la lista de roles
                return view('users.create', ['roles' => $roles]);
            }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'cedula' => 'nullable|string|max:20|unique:users,cedula',
            'celular' => 'nullable|string|max:20',
            'rol_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:8',
        ]);

        // 2. Crear el nuevo usuario
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cedula' => $request->cedula,
            'celular' => $request->celular,
            'rol_id' => $request->rol_id,
            'password' => Hash::make($request->password),
        ]);

        // 3. Redirigir a la lista de usuarios con un mensaje de éxito
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
            {
                // Laravel inyecta automáticamente el usuario gracias al Route Model Binding
                $roles = Role::all();
                return view('users.edit', ['user' => $user, 'roles' => $roles]);
            }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // 1. Validar los datos
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'cedula' => 'nullable|string|max:20|unique:users,cedula,' . $user->id,
            'celular' => 'nullable|string|max:20',
            'rol_id' => 'required|exists:roles,id',
            'password' => 'nullable|string|min:8',
        ]);

        // 2. Actualizar los datos del usuario
        $user->fill([
            'name' => $request->name,
            'email' => $request->email,
            'cedula' => $request->cedula,
            'celular' => $request->celular,
            'rol_id' => $request->rol_id,
        ]);

        // 3. Actualizar la contraseña solo si se proporcionó una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // 4. Redirigir con mensaje de éxito
        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
                public function destroy(User $user)
                {
                    // 1. Eliminar el usuario de la base de datos
                    $user->delete();
                
                    // 2. Redirigir a la lista con un mensaje de éxito
                    return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
                }
}
