@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="hero-section text-center mb-5" style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ asset('images/hero-bg.png') }}');">
    <div class="container">
        <h1 class="hero-title mb-3">Encuentra tu Paraíso</h1>
        <p class="lead mb-4 fs-3">Descubre los destinos más exclusivos al mejor precio</p>
        <a href="#paquetes" class="btn btn-light btn-lg px-5 text-primary fw-bold rounded-pill shadow">Explorar Ofertas</a>
    </div>
</div>

<div class="container" id="paquetes">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Paquetes Destacados</h2>
        @auth
            @if(Auth::user()->isAdvanced() || Auth::user()->isAdmin())
                <a href="{{ route('vacacion.create') }}" class="btn btn-success">Crear Paquete</a>
            @endif
        @endauth
    </div>
    
    @if(session('mensajeTexto'))
        <div class="alert alert-success">
            {{ session('mensajeTexto') }}
        </div>
    @endif

    <form method="GET" action="{{ route('vacacion.index') }}" class="mb-5 p-4 bg-white rounded shadow-sm">
        <div class="row g-3">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="¿A dónde quieres ir?" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="idtipo" class="form-select">
                    <option value="">Todos los tipos de viaje</option>
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id }}" {{ request('idtipo') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-grid gap-2 d-md-block">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </div>
        @if(request('search') || request('idtipo'))
            <div class="mt-2">
                <a href="{{ route('vacacion.index') }}" class="text-muted small text-decoration-none">Limpiar filtros X</a>
            </div>
        @endif
    </form>

    <!-- List -->
    <div class="row">
        @foreach($vacacions as $vacacion)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <!-- Display first photo if exists -->
                    @if($vacacion->fotos->count() > 0)
                        <img src="{{ asset('storage/' . $vacacion->fotos->first()->ruta) }}" class="card-img-top" alt="{{ $vacacion->titulo }}" style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-secondary text-white d-flex justify-content-center align-items-center" style="height: 200px;">
                            Sin Imagen
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $vacacion->titulo }}</h5>
                        <p class="card-text text-muted"><small>{{ $vacacion->pais }}</small></p>
                        <p class="card-text">{{ Str::limit($vacacion->descripcion, 100) }}</p>
                        <p><strong>Precio:</strong> {{ number_format($vacacion->precio, 2) }} €</p>
                        <p><strong>Tipo:</strong> <span class="badge bg-info">{{ $vacacion->tipo->nombre }}</span></p>
                    </div>
                    <div class="card-footer bg-white border-top-0 d-flex justify-content-between">
                        <a href="{{ route('vacacion.show', $vacacion) }}" class="btn btn-primary btn-sm">Ver Detalles</a>
                        @auth
                            @if(Auth::user()->isAdvanced() || Auth::user()->isAdmin())
                                <div class="d-flex gap-1">
                                    <a href="{{ route('vacacion.edit', $vacacion) }}" class="btn btn-warning btn-sm">Editar</a>
                                </div>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        {{ $vacacions->withQueryString()->links() }}
    </div>
</div>
@endsection
