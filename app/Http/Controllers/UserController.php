<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View|RedirectResponse
    {
        // Enforce Admin Access
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('vacacion.index')->with(['mensajeTexto' => 'Acceso denegado: Se requieren permisos de Administrador.']);
        }

        $users = User::paginate(15);
        
        // Define available roles for the view
        $roles = ['user', 'advanced', 'admin'];

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // Enforce Admin Access
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect()->route('vacacion.index')->with(['mensajeTexto' => 'Acceso denegado.']);
        }

        $request->validate([
            'rol' => 'required|in:user,advanced,admin',
        ]);

        // Prevent admin from removing their own admin status (safety check)
        if ($user->id === Auth::id() && $request->rol !== 'admin') {
             return back()->with(['mensajeTexto' => 'Error: No puedes quitarte tu propio rol de administrador.']);
        }

        $user->rol = $request->rol;
        $user->save();

        return back()->with(['mensajeTexto' => "Rol de usuario actualizado correctamente a '{$request->rol}'."]);
    }
}
