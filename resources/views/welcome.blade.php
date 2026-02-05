@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<div class="hero-section text-center position-relative d-flex align-items-center justify-content-center" style="min-height: 80vh; background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/hero-bg.png') }}'); background-size: cover; background-position: center;">
    <div class="container position-relative z-1 text-white">
        <h1 class="display-2 fw-bold mb-4" style="font-family: 'Playfair Display', serif; text-shadow: 2px 2px 4px rgba(0,0,0,0.5);">Bienvenido a Destino Paraíso</h1>
        <p class="lead mb-5 fs-3" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5); max-width: 800px; margin: 0 auto;">Descubre los lugares más exóticos y vive experiencias inolvidables. Tu próxima aventura comienza aquí.</p>
        <a href="{{ route('vacacion.index') }}" class="btn btn-primary btn-lg rounded-pill px-5 py-3 shadow-lg fw-bold" style="font-size: 1.2rem; background-color: var(--primary-color); border: none; transition: transform 0.3s ease;">
            VER TODOS LOS PAQUETES DISPONIBLES
        </a>
    </div>
</div>

<!-- Features Section -->
<div class="container py-5 my-5">
    <div class="row text-center g-4">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 hover-card" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="mb-3 text-primary">
                        <i class="bi bi-globe-americas" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3" style="font-family: 'Playfair Display', serif;">Destinos Exclusivos</h3>
                    <p class="text-muted">Seleccionamos cuidadosamente cada destino para asegurarnos de que vivas una experiencia única e inigualable.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 hover-card" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="mb-3 text-primary">
                        <i class="bi bi-shield-check" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3" style="font-family: 'Playfair Display', serif;">Viajes Seguros</h3>
                    <p class="text-muted">Tu seguridad es nuestra prioridad. Trabajamos con los mejores proveedores para garantizar tu tranquilidad.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm p-4 hover-card" style="border-radius: 20px;">
                <div class="card-body">
                    <div class="mb-3 text-primary">
                        <i class="bi bi-heart" style="font-size: 3rem;"></i>
                    </div>
                    <h3 class="h4 fw-bold mb-3" style="font-family: 'Playfair Display', serif;">Experiencias Únicas</h3>
                    <p class="text-muted">Creamos recuerdos que durarán toda la vida. Deja que nos encarguemos de los detalles.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
