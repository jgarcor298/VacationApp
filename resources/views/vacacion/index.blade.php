@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="hero-section text-center mb-5 position-relative" style="background-image: linear-gradient(rgba(13, 148, 136, 0.7), rgba(0, 0, 0, 0.6)), url('{{ asset('images/hero-bg.png') }}'); background-size: cover; background-position: center; padding: 120px 0;">
    <div class="container position-relative z-1">
        <h1 class="display-3 fw-bold text-white mb-3" style="font-family: 'Playfair Display', serif; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">Descubre Tu Próxima Aventura</h1>
        <p class="lead text-white mb-4 fs-4" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">Explora los destinos más exclusivos y vive experiencias inolvidables</p>
    </div>
</div>

<div class="container" id="paquetes" style="margin-top: -60px; position: relative; z-index: 2;">
    <!-- Search Filter -->
    <div class="card border-0 shadow-lg mb-5" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 15px;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('vacacion.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-5">
                        <label for="search" class="form-label fw-bold text-primary">Buscar Destino</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-primary"><i class="bi bi-search"></i></span>
                            <input type="text" id="search" name="search" class="form-control border-start-0 ps-0" placeholder="Ej: París, Playa..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="idtipo" class="form-label fw-bold text-primary">Tipo de Viaje</label>
                        <select name="idtipo" id="idtipo" class="form-select">
                            <option value="">Todos los estilos</option>
                            @foreach($tipos as $tipo)
                                <option value="{{ $tipo->id }}" {{ request('idtipo') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2" style="background-color: var(--primary-color); border: none;">ENCONTRAR VIAJE</button>
                    </div>
                </div>
                @if(request('search') || request('idtipo'))
                <div class="mt-3 text-end">
                    <a href="{{ route('vacacion.index') }}" class="text-secondary text-decoration-none small"><i class="bi bi-x-circle me-1"></i> Limpiar filtros</a>
                </div>
                @endif
            </form>
        </div>
    </div>

    <!-- Header & Admin Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="section-title position-relative pb-2" style="color: var(--dark-text); font-family: 'Playfair Display', serif;">
            Paquetes Disponibles
            <span class="position-absolute bottom-0 start-0 w-50" style="height: 3px; background-color: var(--secondary-color);"></span>
        </h2>
        @auth
            @if(Auth::user()->isAdvanced() || Auth::user()->isAdmin())
                <a href="{{ route('vacacion.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm"><i class="bi bi-plus-lg me-2"></i>Crear Paquete</a>
            @endif
        @endauth
    </div>

    @if(session('mensajeTexto'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('mensajeTexto') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Package Grid -->
    @if($vacacions->count() > 0)
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-5">
            @foreach($vacacions as $vacacion)
                <div class="col">
                    <div class="card h-100 border-0 shadow-sm hover-card rounded-4 overflow-hidden">
                        <div class="position-relative">
                             @if($vacacion->fotos->count() > 0)
                                <img src="{{ asset('storage/' . $vacacion->fotos->first()->ruta) }}" class="card-img-top" alt="{{ $vacacion->titulo }}" style="height: 240px; object-fit: cover; transition: transform 0.5s ease;">
                            @else
                                <div class="bg-light d-flex justify-content-center align-items-center" style="height: 240px;">
                                    <span class="text-muted"><i class="bi bi-image fs-1"></i></span>
                                </div>
                            @endif
                            <div class="position-absolute top-0 end-0 m-3">
                                <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill fw-bold" style="font-size: 0.85rem;">{{ $vacacion->tipo->nombre }}</span>
                            </div>
                            <div class="price-tag position-absolute bottom-0 start-0 bg-primary text-white px-3 py-2 rounded-end" style="transform: translateY(50%); bottom: 0; background-color: var(--secondary-color) !important;">
                                <span class="fw-bold fs-5">{{ number_format($vacacion->precio, 0, ',', '.') }} €</span>
                            </div>
                        </div>
                        
                        <div class="card-body pt-4 px-4 pb-3">
                            <div class="d-flex align-items-center mb-2 text-muted small">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $vacacion->pais }}
                            </div>
                            <h5 class="card-title fw-bold mb-3 text-dark" style="font-family: 'Playfair Display', serif;">{{ $vacacion->titulo }}</h5>
                            <p class="card-text text-secondary" style="font-size: 0.95rem;">{{ Str::limit($vacacion->descripcion, 90) }}</p>
                        </div>
                        
                        <div class="card-footer bg-white border-top-0 px-4 pb-4 pt-0 d-flex justify-content-between align-items-center">
                            <a href="{{ route('vacacion.show', $vacacion) }}" class="btn btn-outline-primary rounded-pill px-4 text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Ver Detalles</a>
                            
                             @auth
                                @if(Auth::user()->isAdvanced() || Auth::user()->isAdmin())
                                    <div class="btn-group">
                                        <a href="{{ route('vacacion.edit', $vacacion) }}" class="btn btn-sm btn-light text-warning" title="Editar"><i class="bi bi-pencil-fill"></i></a>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $vacacions->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
            </div>
            <h3 class="text-muted">No encontramos paquetes que coincidan</h3>
            <p class="text-muted">Intenta ajustar tus filtros de búsqueda</p>
            <a href="{{ route('vacacion.index') }}" class="btn btn-primary mt-2">Ver todos los paquetes</a>
        </div>
    @endif
</div>

@endsection
