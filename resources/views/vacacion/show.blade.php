@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb / Back Link -->
    <div class="mb-4">
        <a href="{{ route('vacacion.index') }}" class="text-decoration-none text-secondary">
            <i class="bi bi-arrow-left me-1"></i> Volver a todos los paquetes
        </a>
    </div>

    <div class="row g-4">
        <!-- Main Content (Left Column) -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                @if($vacacion->fotos->count() > 0)
                    <div id="carouselFotos{{ $vacacion->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($vacacion->fotos as $key => $foto)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $foto->ruta) }}" class="d-block w-100" alt="{{ $vacacion->titulo }}" style="height: 500px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        @if($vacacion->fotos->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselFotos{{ $vacacion->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.3); border-radius: 50%;"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselFotos{{ $vacacion->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: rgba(0,0,0,0.3); border-radius: 50%;"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                @endif
                
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h1 class="card-title display-5 fw-bold" style="font-family: 'Playfair Display', serif;">{{ $vacacion->titulo }}</h1>
                    </div>
                    
                    <div class="d-flex align-items-center mb-4 text-muted">
                        <span class="badge bg-primary me-3 px-3 py-2 rounded-pill">{{ $vacacion->tipo->nombre }}</span>
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $vacacion->pais }}
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-3">Sobre este destino</h5>
                        <p class="lead text-secondary" style="font-size: 1.1rem; line-height: 1.8;">{{ $vacacion->descripcion }}</p>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <h3 class="h4 fw-bold mb-4" style="font-family: 'Playfair Display', serif;">Opiniones de Viajeros ({{ $vacacion->comentarios->count() }})</h3>
                
                <div class="mb-4">
                     <ul class="list-unstyled">
                        @forelse($vacacion->comentarios as $comentario)
                            <li class="mb-4 pb-4 border-bottom last-no-border">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="fw-bold mb-0">{{ $comentario->user->name }}</h6>
                                    <small class="text-muted">{{ $comentario->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="text-warning mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $comentario->puntuacion ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                </div>
                                <p class="text-secondary mb-0">{{ $comentario->texto }}</p>
                            </li>
                        @empty
                            <li class="text-muted fst-italic">Aún no hay opiniones. ¡Sé el primero en comentar después de tu viaje!</li>
                        @endforelse
                    </ul>
                </div>

                @auth
                    <div class="bg-light p-4 rounded-3">
                        <h5 class="fw-bold mb-3">Cuéntanos tu experiencia</h5>
                        <form action="{{ route('comentario.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="idvacacion" value="{{ $vacacion->id }}">
                            <div class="mb-3">
                                <label class="form-label small text-muted text-uppercase fw-bold">Tu Puntuación</label>
                                <div class="rating-css">
                                    <!-- Simple select for functionality/robustness -->
                                    <select name="puntuacion" class="form-select w-auto" required>
                                        <option value="5" selected>⭐⭐⭐⭐⭐ (Excelente)</option>
                                        <option value="4">⭐⭐⭐⭐ (Muy bueno)</option>
                                        <option value="3">⭐⭐⭐ (Bueno)</option>
                                        <option value="2">⭐⭐ (Regular)</option>
                                        <option value="1">⭐ (Malo)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small text-muted text-uppercase fw-bold">Tu Comentario</label>
                                <textarea name="texto" class="form-control border-0 shadow-sm" rows="3" required placeholder="¿Qué fue lo que más te gustó?"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary px-4">Publicar Opinión</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Sidebar (Right Column) -->
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 100px; z-index: 10;">
                
                <!-- Booking Card -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-primary text-white p-4 text-center border-0">
                        <span class="d-block text-white-50 text-uppercase small fw-bold mb-1">Precio por persona</span>
                        <h2 class="display-6 fw-bold mb-0">{{ number_format($vacacion->precio, 0, ',', '.') }} €</h2>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Cancelación gratuita hasta 48h</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Seguro de viaje incluido</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Guía local experto</li>
                        </ul>

                        @auth
                            <form action="{{ route('reserva.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="idvacacion" value="{{ $vacacion->id }}">
                                <button type="submit" class="btn btn-success w-100 py-3 fw-bold rounded-pill shadow-sm" style="background-color: var(--secondary-color); border: none;">
                                    ¡RESERVAR AHORA!
                                </button>
                            </form>
                            <p class="text-center small text-muted mt-3 mb-0"><i class="bi bi-shield-lock"></i> Reserva 100% segura</p>
                        @else
                            <div class="text-center">
                                <p class="mb-3 text-muted">Inicia sesión para reservar esta aventura.</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 py-2 rounded-pill">Iniciar Sesión</a>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Admin Action Card -->
                 @auth
                    @if(Auth::user()->isAdvanced() || Auth::user()->isAdmin())
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-header bg-dark text-white fw-bold py-3">
                                <i class="bi bi-gear-fill me-2"></i> Administración
                            </div>
                            <div class="card-body p-3">
                                <a href="{{ route('vacacion.edit', $vacacion) }}" class="btn btn-warning w-100 mb-2">
                                    <i class="bi bi-pencil-square me-2"></i> Editar Paquete
                                </a>
                                <form action="{{ route('vacacion.destroy', $vacacion) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este paquete? Esta acción no se puede deshacer.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="bi bi-trash-fill me-2"></i> Eliminar Paquete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @endauth

            </div>
        </div>
    </div>
</div>

<style>
    .last-no-border:last-child {
        border-bottom: none !important;
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
</style>
@endsection
