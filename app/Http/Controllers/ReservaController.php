<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Reserva;
use App\Models\Vacacion;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'idvacacion' => 'required|exists:vacacion,id',
        ]);

        try {
            Reserva::create([
                'iduser' => Auth::id(),
                'idvacacion' => $request->idvacacion,
            ]);
            $message = ['mensajeTexto' => 'Reserva realizada con éxito.'];
        } catch (\Exception $e) {
            $message = ['mensajeTexto' => 'Error al realizar la reserva.'];
            return back()->withErrors($message);
        }

        return back()->with($message);
    }
}
