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

    public function index(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        if (!Auth::user()->isAdmin() && !Auth::user()->isAdvanced()) {
             return redirect()->route('vacacion.index')->with(['mensajeTexto' => 'No tienes permiso para ver las reservas.']);
        }

        $reservas = Reserva::with(['user', 'vacacion'])->orderBy('id', 'desc')->paginate(15);

        return view('admin.reservas.index', compact('reservas'));
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
