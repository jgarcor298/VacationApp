@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Editar Paquete Vacacional</div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('vacacion.update', $vacacion) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ old('titulo', $vacacion->titulo) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $vacacion->descripcion) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio (por persona)</label>
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" value="{{ old('precio', $vacacion->precio) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="pais" class="form-label">País</label>
                            <input type="text" class="form-control" id="pais" name="pais" value="{{ old('pais', $vacacion->pais) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="idtipo" class="form-label">Tipo de Vacación</label>
                            <select class="form-control" id="idtipo" name="idtipo" required>
                                <option value="">Seleccionar...</option>
                                @foreach($tipos as $id => $nombre)
                                    <option value="{{ $id }}" {{ old('idtipo', $vacacion->idtipo) == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Principal (Dejar vacío para mantener)</label>
                            @if($vacacion->fotos->count() > 0)
                                <div class="mb-2 d-flex gap-2 flex-wrap">
                                    @foreach($vacacion->fotos as $foto)
                                        <img src="{{ asset('storage/' . $foto->ruta) }}" alt="Foto actual" style="max-height: 100px; max-width: 100px; object-fit: cover;">
                                    @endforeach
                                </div>
                            @endif
                            <input type="file" class="form-control" id="foto" name="foto[]" accept="image/*" multiple>
                        </div>

                        <button type="submit" class="btn btn-primary">Actualizar</button>
                        <a href="{{ route('vacacion.index') }}" class="btn btn-secondary">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
