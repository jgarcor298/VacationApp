<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacacionCreateRequest;
use App\Models\Vacacion;
use App\Models\Tipo;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class VacacionController extends Controller
{
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Request $request): View {
        $query = Vacacion::query();
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('titulo', 'like', '%' . $request->search . '%')
                  ->orWhere('pais', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->has('idtipo') && $request->idtipo != '') {
            $query->where('idtipo', $request->idtipo);
        }
        
        $vacacions = $query->with('fotos', 'tipo')->paginate(5);
        $tipos = Tipo::all();
        
        return view('vacacion.index', ['vacacions' => $vacacions, 'tipos' => $tipos]);
    }

    public function create(): \Illuminate\Http\RedirectResponse|View {
        if (!Auth::user()->isAdmin() && !Auth::user()->isAdvanced()) {
             return redirect()->route('vacacion.index')->with(['mensajeTexto' => 'No tienes permiso para crear paquetes.']);
        }
        $tipos = Tipo::pluck('nombre', 'id');
        return view('vacacion.create', ['tipos' => $tipos]);
    }

    public function store(VacacionCreateRequest $request): RedirectResponse {
        if (!Auth::user()->isAdmin() && !Auth::user()->isAdvanced()) {
             return redirect()->route('vacacion.index')->with(['mensajeTexto' => 'No tienes permiso.']);
        }
        $vacacion = new Vacacion($request->except('foto'));
        
        $result = false;
        try {
            $result = $vacacion->save();
            $txtmessage = 'La vacación ha sido creada correctamente.';
            
            if ($request->hasFile('foto')) {
                $this->upload($request, $vacacion);
            }
            
        } catch(\Exception $e) {
            $txtmessage = 'Error al crear la vacación: ' . $e->getMessage();
            $result = false;
        }

        $message = ['mensajeTexto' => $txtmessage];
        
        if($result) {
            return redirect()->route('vacacion.index')->with($message);
        } else {
            return back()->withInput()->withErrors($message);
        }
    }

    public function show(Vacacion $vacacion): View {
        $vacacion->load('fotos', 'tipo', 'comentarios.user');
        return view('vacacion.show', ['vacacion' => $vacacion]);
    }

    public function edit(Vacacion $vacacion): \Illuminate\Http\RedirectResponse|View {
        if (!Auth::user()->isAdmin() && !Auth::user()->isAdvanced()) {
             return redirect()->route('vacacion.index')->with(['mensajeTexto' => 'No tienes permiso.']);
        }
        $tipos = Tipo::pluck('nombre', 'id');
        return view('vacacion.edit', ['vacacion' => $vacacion, 'tipos' => $tipos]);
    }

    public function update(Request $request, Vacacion $vacacion): RedirectResponse {
        if (!Auth::user()->isAdmin() && !Auth::user()->isAdvanced()) {
             return redirect()->route('vacacion.index')->with(['mensajeTexto' => 'No tienes permiso.']);
        }
        $request->validate([
            'titulo' => 'required|string|max:100',
            'precio' => 'required|numeric',
            'idtipo' => 'required|exists:tipo,id',
        ]);

        $result = false;
        try {
            $vacacion->fill($request->except('foto'));
            $result = $vacacion->save();
            $txtmessage = 'La vacación ha sido actualizada.';

            if ($request->hasFile('foto')) {
                $this->upload($request, $vacacion);
            }
            
        } catch(\Exception $e) {
            $txtmessage = 'Error al actualizar: ' . $e->getMessage();
        }

        $message = ['mensajeTexto' => $txtmessage];

        if($result) {
            return redirect()->route('vacacion.index')->with($message);
        } else {
            return back()->withInput()->withErrors($message);
        }
    }

    public function destroy(Vacacion $vacacion): RedirectResponse {
        if (!Auth::user()->isAdmin()) {
             return redirect()->route('vacacion.index')->with(['mensajeTexto' => 'Solo el administrador puede eliminar.']);
        }
        try {
            $vacacion->delete();
            $result = true;
            $txtmessage = 'La vacación ha sido eliminada.';
        } catch(\Exception $e) {
            $result = false;
            $txtmessage = 'Error al eliminar la vacación.';
        }
        
        $message = ['mensajeTexto' => $txtmessage];
        return redirect()->route('vacacion.index')->with($message);
    }

    private function upload(Request $request, Vacacion $vacacion): void {
        $images = $request->file('foto');
        
        // Ensure it's an array to handle single or multiple uploads uniformly
        if (!is_array($images)) {
            $images = [$images];
        }

        foreach($images as $image) {
            $name = time() . '_' . uniqid() . '_' . $vacacion->id . '.' . $image->getClientOriginalExtension();
            $ruta = $image->storeAs('vacacion', $name, 'public');
            
            $foto = new Foto();
            $foto->idvacacion = $vacacion->id;
            $foto->ruta = $ruta;
            $foto->save();
        }
    }
}
