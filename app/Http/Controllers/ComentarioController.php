<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comentario;
use Illuminate\Support\Facades\Auth;

class ComentarioController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'idvacacion' => 'required|exists:vacacion,id',
            'texto' => 'required|string|max:500',
            'puntuacion' => 'required|integer|min:1|max:5',
        ]);

        try {
            Comentario::create([
                'iduser' => Auth::id(),
                'idvacacion' => $request->idvacacion,
                'texto' => $request->texto,
                'puntuacion' => $request->puntuacion,
            ]);
            $message = ['mensajeTexto' => 'Comentario enviado.'];
        } catch (\Exception $e) {
            $message = ['mensajeTexto' => 'Error al enviar el comentario.'];
            return back()->withInput()->withErrors($message);
        }

        return back()->with($message);
    }
}
