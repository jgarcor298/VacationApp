@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                @if($vacacion->fotos->count() > 0)
                    <div id="carouselFotos{{ $vacacion->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($vacacion->fotos as $key => $foto)
                                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $foto->ruta) }}" class="d-block w-100 card-img-top" alt="{{ $vacacion->titulo }}" style="height: 400px; object-fit: cover;">
                                </div>
                            @endforeach
                        </div>
                        @if($vacacion->fotos->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselFotos{{ $vacacion->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselFotos{{ $vacacion->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                @endif
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h1 class="card-title display-5">{{ $vacacion->titulo }}</h1>
                        <span class="badge badge-custom fs-6">{{ $vacacion->tipo->nombre }}</span>
                    </div>
                    <p class="text-muted d-flex align-items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill me-2" viewBox="0 0 16 16">
                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                        </svg>
                        {{ $vacacion->pais }}
                    </p>
                    <div class="p-3 bg-light rounded mb-4">
                        <p class="lead mb-0 text-dark">{{ $vacacion->descripcion }}</p>
                    </div>
                    <h3 class="text-primary fw-bold mb-4">{{ number_format($vacacion->precio, 2) }} € <small class="text-muted fs-6 fw-normal">/ por persona</small></h3>
                    
                    @auth
                        <form action="{{ route('reserva.store') }}" method="POST" class="mt-3">
                            @csrf
                            <input type="hidden" name="idvacacion" value="{{ $vacacion->id }}">
                            <button type="submit" class="btn btn-success btn-lg">Reservar Ahora</button>
                        </form>
                    @else
                        <div class="alert alert-info mt-3">
                            Inicia sesión para reservar.
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card">
                <div class="card-header">Comentarios</div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @forelse($vacacion->comentarios as $comentario)
                            <li class="mb-3 border-bottom pb-2">
                                <strong>{{ $comentario->user->name }}</strong> 
                                <span class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $comentario->puntuacion)
                                            ★
                                        @else
                                            ☆
                                        @endif
                                    @endfor
                                </span>
                                <small class="text-muted">{{ $comentario->created_at->diffForHumans() }}</small>
                                <p class="mb-0">{{ $comentario->texto }}</p>
                            </li>
                        @empty
                            <li>No hay comentarios aún.</li>
                        @endforelse
                    </ul>

                    @auth
                        <hr>
                        <h5>Deja tu comentario</h5>
                        <form action="{{ route('comentario.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="idvacacion" value="{{ $vacacion->id }}">
                            <div class="mb-3">
                                <label for="puntuacion" class="form-label">Puntuación</label>
                                <select name="puntuacion" id="puntuacion" class="form-select" required>
                                    <option value="5" selected>★★★★★ (5)</option>
                                    <option value="4">★★★★☆ (4)</option>
                                    <option value="3">★★★☆☆ (3)</option>
                                    <option value="2">★★☆☆☆ (2)</option>
                                    <option value="1">★☆☆☆☆ (1)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <textarea name="texto" class="form-control" rows="3" required placeholder="Escribe tu opinión..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Enviar Comentario</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Sidebar / Additional Info -->
            <div class="card">
                <div class="card-header">Acciones Admin</div>
                <div class="card-body">
                    <a href="{{ route('vacacion.index') }}" class="btn btn-secondary w-100 mb-2">Volver al listado</a>
                    @auth
                        @if(Auth::user()->isAdvanced() || Auth::user()->isAdmin())
                            <a href="{{ route('vacacion.edit', $vacacion) }}" class="btn btn-warning w-100 mb-2">Editar Paquete</a>
                            <form action="{{ route('vacacion.destroy', $vacacion) }}" method="POST" onsubmit="return confirm('¿Estás seguro?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">Eliminar Paquete</button>
                            </form>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
