<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'cedula' => 'nullable|string|max:20|unique:users,cedula,' . $user->id,
            'celular' => 'nullable|string|max:20',
            'cargo' => 'nullable|string|max:255',
            'firma' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Actualizar datos básicos
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'cedula' => $validated['cedula'],
            'celular' => $validated['celular'],
            'cargo' => $validated['cargo'],
        ]);

        // Manejar upload de firma
        if ($request->hasFile('firma')) {
            // Eliminar firma anterior si existe
            if ($user->firma_url && Storage::exists($user->firma_url)) {
                Storage::delete($user->firma_url);
            }

            $firmaPath = $request->file('firma')->store('firmas_usuarios', 'public');
            $user->update(['firma_url' => $firmaPath]);
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Perfil actualizado exitosamente.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Contraseña actualizada exitosamente.');
    }
}